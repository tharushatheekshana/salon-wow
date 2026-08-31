<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Services\AppointmentService;
use Exception;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.public')]
class BookingLookup extends Component
{
    #[Url(as: 'ref')]
    public string $reference = '';

    public ?Appointment $appointment = null;

    public bool $searched = false;

    public ?string $cancelReason = '';

    public bool $showCancelModal = false;

    public ?string $feedbackMessage = null;

    public function mount(): void
    {
        if ($this->reference) {
            $this->search();
        }
    }

    public function search(): void
    {
        $this->validate([
            'reference' => 'required|string|min:3',
        ]);

        $this->appointment = Appointment::with(['service', 'staff.staffProfile', 'review'])
            ->where('booking_reference', trim($this->reference))
            ->first();

        $this->searched = true;
        $this->feedbackMessage = null;
    }

    public function cancelBooking(AppointmentService $appointmentService): void
    {
        if (! $this->appointment) {
            return;
        }

        try {
            $appointmentService->cancelAppointment($this->appointment, $this->cancelReason);
            $this->appointment->refresh();
            $this->showCancelModal = false;
            $this->feedbackMessage = 'Your appointment has been successfully cancelled.';
        } catch (Exception $e) {
            $this->feedbackMessage = $e->getMessage();
        }
    }

    public function render(): View
    {
        return view('livewire.booking-lookup');
    }
}
