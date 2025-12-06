<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * Display payment summary before creating a virtual account.
     */
    public function show(Appointment $appointment)
    {
        $patient = $this->currentPatient();

        if ($appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access');
        }

        if ($appointment->isPaid()) {
            return redirect()->route('patient.appointments.show', $appointment)
                ->with('info', 'Janji temu ini sudah dibayar.');
        }

        if ($appointment->isPaymentExpired()) {
            return redirect()->route('patient.appointments.index')
                ->with('error', 'Pembayaran sudah kedaluwarsa. Silakan buat janji baru.');
        }

        $appointment->loadMissing('doctor.user', 'schedule');

        return view('patient.payments.show', compact('appointment'));
    }

    /**
     * Create a Doovera virtual account for the appointment.
     */
    public function process(Appointment $appointment)
    {
        $patient = $this->currentPatient();

        if ($appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access');
        }

        if ($appointment->isPaid()) {
            return redirect()->route('patient.appointments.show', $appointment)
                ->with('info', 'Janji temu ini sudah dibayar.');
        }

        if ($appointment->isPaymentExpired()) {
            return redirect()->route('patient.appointments.index')
                ->with('error', 'Pembayaran sudah kedaluwarsa. Silakan buat janji baru.');
        }

        $appointment->loadMissing('doctor.user');

        if ($appointment->consultation_fee <= 0 && $appointment->doctor) {
            $appointment->consultation_fee = $appointment->doctor->fee ?? 0;
        }

        $expiredHours = (int) config('services.payment.expired_hours', 24);
        $orderId = 'APT-' . $appointment->id . '-' . now()->timestamp;

        try {
            $response = Http::withHeaders([
                'X-API-Key' => config('services.payment.api_key'),
                'Accept' => 'application/json',
            ])->withoutVerifying()->post(rtrim(config('services.payment.base_url'), '/') . '/virtual-account/create', [
                'external_id' => $orderId,
                'amount' => (int) round($appointment->consultation_fee),
                'customer_name' => $patient->user->name ?? 'Pasien',
                'customer_email' => $patient->user->email ?? 'patient@example.com',
                'customer_phone' => $patient->user->phone ?? '081234567890',
                'description' => 'Pembayaran konsultasi dengan ' . ($appointment->doctor->user->name ?? 'Dokter'),
                'expired_duration' => $expiredHours,
                'callback_url' => route('patient.payments.success', $appointment),
                'metadata' => [
                    'appointment_id' => $appointment->id,
                    'patient_id' => $patient->id,
                    'doctor_id' => $appointment->doctor_id,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();

                $appointment->update([
                    'va_number' => data_get($data, 'data.va_number'),
                    'payment_url' => data_get($data, 'data.payment_url'),
                    'payment_status' => 'pending',
                    'expired_at' => now()->addHours($expiredHours),
                ]);

                return redirect()->route('patient.payments.waiting', $appointment);
            }

            $appointment->update(['payment_status' => 'failed']);

            return redirect()->route('patient.appointments.show', $appointment)
                ->with('error', 'Gagal membuat pembayaran. Silakan coba kembali.');
        } catch (\Throwable $th) {
            $appointment->update(['payment_status' => 'failed']);

            return redirect()->route('patient.appointments.show', $appointment)
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Waiting page while payment is still pending.
     */
    public function waiting(Appointment $appointment)
    {
        $patient = $this->currentPatient();

        if ($appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access');
        }

        if ($appointment->isPaid()) {
            return redirect()->route('patient.payments.success', $appointment);
        }

        if ($appointment->isPaymentExpired()) {
            return redirect()->route('patient.appointments.index')
                ->with('error', 'Pembayaran sudah kedaluwarsa.');
        }

        $appointment->loadMissing('doctor.user', 'schedule');

        return view('patient.payments.waiting', compact('appointment'));
    }

    /**
     * Check payment status via API (sync with payment gateway).
     */
    public function checkStatus(Appointment $appointment)
    {
        $patient = $this->currentPatient();

        if ($appointment->patient_id !== $patient->id) {
            abort(403);
        }

        // If already paid, return immediately
        if ($appointment->isPaid()) {
            return response()->json([
                'status' => 'paid',
                'paid_at' => $appointment->paid_at?->toIso8601String(),
            ]);
        }

        // Try to sync status from payment gateway using correct API endpoint
        try {
            if ($appointment->va_number) {
                $apiUrl = rtrim(config('services.payment.base_url'), '/') . '/virtual-account/' . $appointment->va_number . '/status';
                
                \Illuminate\Support\Facades\Log::info('Checking payment status from gateway', [
                    'appointment_id' => $appointment->id,
                    'va_number' => $appointment->va_number,
                    'api_url' => $apiUrl,
                ]);

                $response = Http::withHeaders([
                    'X-API-Key' => config('services.payment.api_key'),
                    'Accept' => 'application/json',
                ])->timeout(10)->get($apiUrl);

                if ($response->successful()) {
                    $responseData = $response->json();
                    $status = data_get($responseData, 'data.status', 'pending');

                    \Illuminate\Support\Facades\Log::info('Payment gateway response', [
                        'appointment_id' => $appointment->id,
                        'response' => $responseData,
                        'status' => $status,
                    ]);

                    // Update if payment is completed in gateway
                    if (in_array(strtolower($status), ['paid', 'success', 'completed'])) {
                        $appointment->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                        ]);

                        return response()->json([
                            'status' => 'paid',
                            'paid_at' => $appointment->paid_at?->toIso8601String(),
                            'synced' => true,
                            'message' => 'Pembayaran berhasil terdeteksi dari payment gateway!',
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            // Log error but don't fail
            \Illuminate\Support\Facades\Log::warning('Failed to sync payment status', [
                'appointment_id' => $appointment->id,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);
        }

        return response()->json([
            'status' => $appointment->payment_status,
            'paid_at' => $appointment->paid_at?->toIso8601String(),
        ]);
    }

    /**
     * Show the success page after payment confirmation.
     */
    public function success(Appointment $appointment)
    {
        $patient = $this->currentPatient();

        if ($appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access');
        }

        if (! $appointment->isPaid()) {
            return redirect()->route('patient.payments.waiting', $appointment);
        }

        $appointment->loadMissing('doctor.user', 'schedule');

        return view('patient.payments.success', compact('appointment'));
    }

    private function currentPatient()
    {
        $user = Auth::user();

        if (! $user || ! $user->patient) {
            abort(403, 'Patient profile not found');
        }

        return $user->patient->loadMissing('user');
    }
}
