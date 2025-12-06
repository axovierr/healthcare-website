<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Payment webhook received', ['payload' => $request->all()]);

        $secret = config('services.payment.webhook_secret');
        $signature = $request->header('X-Webhook-Signature');

        if ($secret && $signature) {
            $expected = hash_hmac('sha256', $request->getContent(), $secret);

            if (! hash_equals($expected, $signature)) {
                Log::warning('Invalid payment webhook signature', [
                    'expected' => $expected,
                    'received' => $signature,
                ]);

                return response()->json(['error' => 'Invalid signature'], 401);
            }
        }

        $event = $request->input('event');
        $data = $request->input('data', []);
        $metadata = data_get($data, 'metadata', []);

        $appointmentId = data_get($metadata, 'appointment_id');

        if (! $appointmentId) {
            $externalId = data_get($data, 'external_id', '');

            if ($externalId && preg_match('/APT-(\d+)/', $externalId, $matches)) {
                $appointmentId = (int) $matches[1];
            }
        }

        if (! $appointmentId) {
            Log::warning('Webhook missing appointment reference', ['data' => $data]);

            return response()->json(['error' => 'Appointment reference not provided'], 422);
        }

        $appointment = Appointment::find($appointmentId);

        if (! $appointment) {
            Log::warning('Appointment not found for webhook', ['appointment_id' => $appointmentId]);

            return response()->json(['error' => 'Appointment not found'], 404);
        }

    if ($event === 'payment.success') {
            if ($appointment->isPaid()) {
                return response()->json(['message' => 'Already processed'], 200);
            }

            $appointment->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'va_number' => data_get($data, 'va_number', $appointment->va_number),
                'payment_url' => data_get($data, 'payment_url', $appointment->payment_url),
            ]);

            Log::info('Appointment payment marked as paid', ['appointment_id' => $appointmentId]);

            return response()->json(['message' => 'Payment processed'], 200);
        }

        if ($event === 'payment.failed') {
            $appointment->update(['payment_status' => 'failed']);

            Log::info('Appointment payment marked as failed', ['appointment_id' => $appointmentId]);

            return response()->json(['message' => 'Payment failure recorded'], 200);
        }

        if ($event === 'payment.expired') {
            $appointment->update(['payment_status' => 'expired']);

            Log::info('Appointment payment marked as expired', ['appointment_id' => $appointmentId]);

            return response()->json(['message' => 'Payment expiration recorded'], 200);
        }

        Log::info('Unhandled payment event received', [
            'event' => $event,
            'appointment_id' => $appointmentId,
        ]);

        return response()->json(['message' => 'Event ignored'], 200);
    }
}
