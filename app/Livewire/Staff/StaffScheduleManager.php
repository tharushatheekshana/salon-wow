<?php

namespace App\Livewire\Staff;

use App\Models\Appointment;
use App\Models\StaffSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class StaffScheduleManager extends Component
{
    /**
     * @var array<int, array{day_of_week: int, day_name: string, start_time: string, end_time: string, break_start_time: string, break_end_time: string, is_day_off: bool}>
     */
    public array $schedules = [];

    public ?string $feedbackMessage = null;

    public function mount(): void
    {
        /** @var User $user */
        $user = auth()->user();
        $staffSchedules = StaffSchedule::where('user_id', $user->id)
            ->orderBy('day_of_week')
            ->get();

        if ($staffSchedules->isEmpty()) {
            // Seed defaults for this user
            for ($day = 0; $day <= 6; $day++) {
                StaffSchedule::create([
                    'user_id' => $user->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '18:00:00',
                    'break_start_time' => '13:00:00',
                    'break_end_time' => '14:00:00',
                    'is_day_off' => ($day === 0),
                ]);
            }
            $staffSchedules = StaffSchedule::where('user_id', $user->id)->orderBy('day_of_week')->get();
        }

        foreach ($staffSchedules as $sched) {
            $this->schedules[$sched->id] = [
                'day_of_week' => $sched->day_of_week,
                'day_name' => $sched->day_name,
                'start_time' => Carbon::parse($sched->start_time)->format('H:i'),
                'end_time' => Carbon::parse($sched->end_time)->format('H:i'),
                'break_start_time' => $sched->break_start_time ? Carbon::parse($sched->break_start_time)->format('H:i') : '13:00',
                'break_end_time' => $sched->break_end_time ? Carbon::parse($sched->break_end_time)->format('H:i') : '14:00',
                'is_day_off' => (bool) $sched->is_day_off,
            ];
        }
    }

    public function saveSchedules(): void
    {
        foreach ($this->schedules as $id => $data) {
            StaffSchedule::where('id', $id)->where('user_id', auth()->id())->update([
                'start_time' => $data['start_time'].':00',
                'end_time' => $data['end_time'].':00',
                'break_start_time' => $data['break_start_time'].':00',
                'break_end_time' => $data['break_end_time'].':00',
                'is_day_off' => $data['is_day_off'],
            ]);
        }

        $this->feedbackMessage = 'Your working hours & weekly availability have been saved!';
    }

    public function render(): View
    {
        $todayAppointments = Appointment::with(['service', 'customer'])
            ->where('staff_id', auth()->id())
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('start_time')
            ->get();

        return view('livewire.staff.staff-schedule-manager', [
            'todayAppointments' => $todayAppointments,
        ]);
    }
}
