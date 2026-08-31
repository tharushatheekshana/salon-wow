<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentService
{
    public function __construct(
        protected BookingSlotService $slotService
    ) {}

    /**
     * Create a new appointment with concurrency/race-condition safety.
     *
     * @param array{
     *     service_id: int,
     *     staff_id: int|string,
     *     appointment_date: string,
     *     start_time: string,
     *     customer_name: string,
     *     customer_email: string,
     *     customer_phone: string,
     *     customer_id?: int|null,
     *     payment_method?: string,
     *     notes?: string|null
     * } $data
     *
     * @throws Exception
     */
    public function createAppointment(array $data): Appointment
    {
        $service = Service::findOrFail($data['service_id']);
        $date = Carbon::parse($data['appointment_date']);
        $startTime = Carbon::parse($date->toDateString().' '.$data['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        return DB::transaction(function () use ($data, $service, $date, $startTime, $endTime) {
            $staffId = $data['staff_id'];

            // If customer picked "any", find first available staff
            if ($staffId === 'any' || ! $staffId) {
                $availableStaff = $this->slotService->findAvailableStaffForSlot(
                    $service->id,
                    $date->toDateString(),
                    $startTime->format('H:i:s'),
                    $endTime->format('H:i:s')
                );

                if (! $availableStaff) {
                    throw new Exception('No stylist is available for the selected time slot. Please choose another slot.');
                }

                $staffId = $availableStaff->id;
            } else {
                // Validate availability of chosen staff
                $isFree = $this->slotService->isSlotAvailable(
                    $service->id,
                    (int) $staffId,
                    $date->toDateString(),
                    $startTime->format('H:i:s'),
                    $endTime->format('H:i:s')
                );

                if (! $isFree) {
                    throw new Exception('The selected time slot is no longer available. Please select another time.');
                }
            }

            $bookingReference = $this->generateReference();

            return Appointment::create([
                'booking_reference' => $bookingReference,
                'customer_id' => $data['customer_id'] ?? (auth()->check() ? auth()->id() : null),
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'service_id' => $service->id,
                'staff_id' => $staffId,
                'appointment_date' => $date->toDateString(),
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'duration_minutes' => $service->duration_minutes,
                'service_price' => $service->price,
                'discount_amount' => 0.00,
                'total_price' => $service->price,
                'status' => 'confirmed',
                'payment_status' => ($data['payment_method'] ?? '') === 'online' ? 'paid' : 'pay_at_salon',
                'payment_method' => $data['payment_method'] ?? 'pay_at_salon',
                'notes' => $data['notes'] ?? null,
            ]);
        });
    }

    /**
     * Cancel an appointment.
     */
    public function cancelAppointment(Appointment $appointment, ?string $reason = null): bool
    {
        return $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
        ]);
    }

    /**
     * Update appointment status.
     */
    public function updateStatus(Appointment $appointment, string $status): bool
    {
        $validStatuses = ['pending', 'confirmed', 'completed', 'cancelled', 'no_show'];
        if (! in_array($status, $validStatuses, true)) {
            throw new Exception("Invalid appointment status: {$status}");
        }

        return $appointment->update(['status' => $status]);
    }

    /**
     * Generate unique human-readable booking reference.
     */
    protected function generateReference(): string
    {
        do {
            $ref = 'SLN-'.strtoupper(Str::random(6));
        } while (Appointment::where('booking_reference', $ref)->exists());

        return $ref;
    }
}
