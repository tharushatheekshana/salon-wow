<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\User;
use App\Services\AppointmentService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class CustomerAppointments extends Component
{
    public string $activeTab = 'upcoming'; // 'upcoming' or 'past'

    public ?int $cancellingAppointmentId = null;

    public string $cancellationReason = '';

    public bool $showCancelModal = false;

    // Review Modal
    public bool $showReviewModal = false;

    public ?int $reviewingAppointmentId = null;

    public int $rating = 5;

    public string $reviewComment = '';

    public ?string $notificationMessage = null;

    public function mount(): void
    {
        if (! auth()->check()) {
            redirect()->route('login');
        }
    }

    public function openCancelModal(int $id): void
    {
        $this->cancellingAppointmentId = $id;
        $this->cancellationReason = '';
        $this->showCancelModal = true;
    }

    public function confirmCancel(AppointmentService $appointmentService): void
    {
        $appointment = Appointment::where('id', $this->cancellingAppointmentId)
            ->where(function ($q) {
                $q->where('customer_id', auth()->id())
                    ->orWhere('customer_email', auth()->user()->email);
            })
            ->first();

        if ($appointment) {
            $appointmentService->cancelAppointment($appointment, $this->cancellationReason);
            $this->notificationMessage = 'Appointment has been cancelled successfully.';
        }

        $this->showCancelModal = false;
    }

    public function openReviewModal(int $id): void
    {
        $this->reviewingAppointmentId = $id;
        $this->rating = 5;
        $this->reviewComment = '';
        $this->showReviewModal = true;
    }

    public function submitReview(): void
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'reviewComment' => 'required|string|min:5|max:1000',
        ]);

        $appointment = Appointment::where('id', $this->reviewingAppointmentId)
            ->where(function ($q) {
                $q->where('customer_id', auth()->id())
                    ->orWhere('customer_email', auth()->user()->email);
            })
            ->first();

        if ($appointment) {
            Review::updateOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'customer_id' => auth()->id(),
                    'service_id' => $appointment->service_id,
                    'staff_id' => $appointment->staff_id,
                    'rating' => $this->rating,
                    'comment' => $this->reviewComment,
                    'is_published' => true,
                ]
            );

            $this->notificationMessage = 'Thank you for your review!';
        }

        $this->showReviewModal = false;
    }

    public function render(): View
    {
        /** @var User $user */
        $user = auth()->user();

        $upcomingAppointments = Appointment::with(['service', 'staff.staffProfile'])
            ->where(function ($q) use ($user) {
                $q->where('customer_id', $user->id)
                    ->orWhere('customer_email', $user->email);
            })
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();

        $pastAppointments = Appointment::with(['service', 'staff.staffProfile', 'review'])
            ->where(function ($q) use ($user) {
                $q->where('customer_id', $user->id)
                    ->orWhere('customer_email', $user->email);
            })
            ->where(function ($q) {
                $q->whereDate('appointment_date', '<', now()->toDateString())
                    ->orWhereIn('status', ['completed', 'cancelled']);
            })
            ->orderByDesc('appointment_date')
            ->orderByDesc('start_time')
            ->get();

        return view('livewire.customer-appointments', [
            'upcomingAppointments' => $upcomingAppointments,
            'pastAppointments' => $pastAppointments,
        ]);
    }
}
