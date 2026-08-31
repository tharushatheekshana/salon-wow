<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\StaffLeave;
use App\Models\StaffSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BookingSlotService
{
    /**
     * Get available time slots for a service, stylist, and date.
     *
     * @return array<int, array{
     *     start_time: string,
     *     end_time: string,
     *     formatted_start: string,
     *     formatted_end: string,
     *     label: string,
     *     staff_id: int,
     *     staff_name: string
     * }>
     */
    public function getAvailableSlots(int $serviceId, int|string|null $staffId, string $dateString): array
    {
        $service = Service::find($serviceId);
        if (! $service || ! $service->is_active) {
            return [];
        }

        $date = Carbon::parse($dateString);
        if ($date->isPast() && ! $date->isToday()) {
            return [];
        }

        if ($staffId && $staffId !== 'any') {
            $staff = User::where('id', $staffId)->where('role', 'staff')->first();
            if (! $staff) {
                return [];
            }

            return $this->getStaffSlotsForDate($staff, $service, $date);
        }

        // "Any Available" stylist logic
        $eligibleStaff = $this->getEligibleStaffForService($service);
        $allSlots = [];

        foreach ($eligibleStaff as $staff) {
            $staffSlots = $this->getStaffSlotsForDate($staff, $service, $date);
            foreach ($staffSlots as $slot) {
                $timeKey = $slot['start_time'];
                // Keep the first available staff for this time key, or group them
                if (! isset($allSlots[$timeKey])) {
                    $allSlots[$timeKey] = $slot;
                }
            }
        }

        ksort($allSlots);

        return array_values($allSlots);
    }

    /**
     * Get staff eligible to perform this service.
     *
     * @return Collection<int, User>
     */
    public function getEligibleStaffForService(Service $service): Collection
    {
        $staffWithService = $service->staff()->where('role', 'staff')->get();

        if ($staffWithService->isNotEmpty()) {
            return $staffWithService;
        }

        // Fallback to all active staff members
        return User::where('role', 'staff')
            ->whereHas('staffProfile', function ($query) {
                $query->where('is_active', true);
            })
            ->orWhereDoesntHave('staffProfile')
            ->where('role', 'staff')
            ->get();
    }

    /**
     * Calculate free slots for a specific staff member on a given date.
     *
     * @return array<int, array{
     *     start_time: string,
     *     end_time: string,
     *     formatted_start: string,
     *     formatted_end: string,
     *     label: string,
     *     staff_id: int,
     *     staff_name: string
     * }>
     */
    public function getStaffSlotsForDate(User $staff, Service $service, Carbon $date): array
    {
        $dayOfWeek = $date->dayOfWeek; // 0 = Sunday, 1 = Monday ... 6 = Saturday

        // Check if staff has schedule for this day
        $schedule = StaffSchedule::where('user_id', $staff->id)
            ->where('day_of_week', $dayOfWeek)
            ->first();

        if (! $schedule || $schedule->is_day_off) {
            return [];
        }

        // Check if staff is on leave
        $onLeave = StaffLeave::where('user_id', $staff->id)
            ->where('leave_date', $date->toDateString())
            ->where('status', 'approved')
            ->exists();

        if ($onLeave) {
            return [];
        }

        // Fetch existing appointments on that date
        $existingAppointments = Appointment::where('staff_id', $staff->id)
            ->whereDate('appointment_date', $date->toDateString())
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->get();

        $duration = $service->duration_minutes;
        $buffer = $service->buffer_time_minutes;
        $totalSlotDuration = $duration + $buffer;

        $startTime = Carbon::parse($date->toDateString().' '.$schedule->start_time);
        $endTime = Carbon::parse($date->toDateString().' '.$schedule->end_time);

        $breakStart = $schedule->break_start_time ? Carbon::parse($date->toDateString().' '.$schedule->break_start_time) : null;
        $breakEnd = $schedule->break_end_time ? Carbon::parse($date->toDateString().' '.$schedule->break_end_time) : null;

        $slots = [];
        $current = $startTime->copy();
        $now = Carbon::now();

        // 15-minute slot intervals for flexible booking
        $stepMinutes = 30;

        while ($current->copy()->addMinutes($duration)->lte($endTime)) {
            $slotStart = $current->copy();
            $slotEnd = $current->copy()->addMinutes($duration);

            // If booking for today, slot must be at least 15 minutes in the future
            if ($date->isToday() && $slotStart->lte($now->copy()->addMinutes(15))) {
                $current->addMinutes($stepMinutes);

                continue;
            }

            // Check break overlap
            if ($breakStart && $breakEnd) {
                if ($slotStart->lt($breakEnd) && $slotEnd->gt($breakStart)) {
                    $current->addMinutes($stepMinutes);

                    continue;
                }
            }

            // Check existing appointment overlap
            $hasConflict = false;
            foreach ($existingAppointments as $appointment) {
                $appStart = Carbon::parse($date->toDateString().' '.$appointment->start_time);
                $appEnd = Carbon::parse($date->toDateString().' '.$appointment->end_time);

                // Slot overlaps with appointment
                if ($slotStart->lt($appEnd) && $slotEnd->gt($appStart)) {
                    $hasConflict = true;
                    break;
                }
            }

            if (! $hasConflict) {
                $slots[] = [
                    'start_time' => $slotStart->format('H:i:s'),
                    'end_time' => $slotEnd->format('H:i:s'),
                    'formatted_start' => $slotStart->format('g:i A'),
                    'formatted_end' => $slotEnd->format('g:i A'),
                    'label' => $slotStart->format('g:i A').' - '.$slotEnd->format('g:i A'),
                    'staff_id' => $staff->id,
                    'staff_name' => $staff->name,
                ];
            }

            $current->addMinutes($stepMinutes);
        }

        return $slots;
    }

    /**
     * Check if a specific slot is available right before booking.
     */
    public function isSlotAvailable(int $serviceId, int $staffId, string $dateString, string $startTime, string $endTime, ?int $excludeAppointmentId = null): bool
    {
        $date = Carbon::parse($dateString);
        $staff = User::where('id', $staffId)->where('role', 'staff')->first();
        if (! $staff) {
            return false;
        }

        $query = Appointment::where('staff_id', $staffId)
            ->whereDate('appointment_date', $date->toDateString())
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                    ->where('end_time', '>', $startTime);
            });

        if ($excludeAppointmentId) {
            $query->where('id', '!=', $excludeAppointmentId);
        }

        return ! $query->exists();
    }

    /**
     * Find available staff member for a specific service and time slot.
     */
    public function findAvailableStaffForSlot(int $serviceId, string $dateString, string $startTime, string $endTime): ?User
    {
        $service = Service::find($serviceId);
        if (! $service) {
            return null;
        }

        $eligibleStaff = $this->getEligibleStaffForService($service);

        foreach ($eligibleStaff as $staff) {
            if ($this->isSlotAvailable($serviceId, $staff->id, $dateString, $startTime, $endTime)) {
                return $staff;
            }
        }

        return null;
    }
}
