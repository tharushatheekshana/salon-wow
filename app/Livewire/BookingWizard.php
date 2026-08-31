<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Services\AppointmentService;
use App\Services\BookingSlotService;
use Carbon\Carbon;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('layouts.public')]
class BookingWizard extends Component
{
    // Wizard step: 1 = Service, 2 = Stylist, 3 = Date & Time, 4 = Details & Payment, 5 = Confirmation
    public int $currentStep = 1;

    // Selections
    #[Url(as: 'category')]
    public ?int $selectedCategoryId = null;

    #[Url(as: 'service')]
    public ?int $selectedServiceId = null;

    #[Url(as: 'staff')]
    public string|int|null $selectedStaffId = 'any'; // 'any' or user_id

    public string $selectedDate = '';

    public string $selectedSlot = ''; // start_time string, e.g. "09:00:00"

    public ?string $selectedSlotLabel = '';

    // Customer form details
    public string $customerName = '';

    public string $customerEmail = '';

    public string $customerPhone = '';

    public string $notes = '';

    public string $paymentMethod = 'pay_at_salon'; // 'pay_at_salon' or 'online'

    // Confirmation details
    public ?Appointment $confirmedAppointment = null;

    // Search and filter
    public string $searchService = '';

    // Error handling
    public ?string $errorMessage = null;

    public function mount(BookingSlotService $slotService): void
    {
        $this->selectedDate = Carbon::today()->format('Y-m-d');

        if (auth()->check()) {
            $user = auth()->user();
            $this->customerName = $user->name;
            $this->customerEmail = $user->email;
            $this->customerPhone = $user->phone ?? '';
        }

        if ($this->selectedServiceId) {
            $service = Service::find($this->selectedServiceId);
            if ($service) {
                $this->selectedCategoryId = $service->category_id;
            }
        }
    }

    public function selectCategory(?int $categoryId): void
    {
        $this->selectedCategoryId = $categoryId;
    }

    public function selectService(int $serviceId): void
    {
        $this->selectedServiceId = $serviceId;
        $this->errorMessage = null;
        $this->currentStep = 2;
    }

    public function selectStaff(string|int $staffId): void
    {
        $this->selectedStaffId = $staffId;
        $this->errorMessage = null;
        $this->selectedSlot = '';
        $this->selectedSlotLabel = '';
        $this->currentStep = 3;
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;
        $this->selectedSlot = '';
        $this->selectedSlotLabel = '';
        $this->errorMessage = null;
    }

    public function selectSlot(string $startTime, string $label): void
    {
        $this->selectedSlot = $startTime;
        $this->selectedSlotLabel = $label;
        $this->errorMessage = null;
        $this->currentStep = 4;
    }

    public function goToStep(int $step): void
    {
        if ($step < $this->currentStep) {
            $this->currentStep = $step;
            $this->errorMessage = null;
        }
    }

    public function confirmBooking(AppointmentService $appointmentService): void
    {
        $this->validate([
            'selectedServiceId' => 'required|exists:services,id',
            'selectedDate' => 'required|date|after_or_equal:today',
            'selectedSlot' => 'required',
            'customerName' => 'required|string|min:2|max:100',
            'customerEmail' => 'required|email|max:150',
            'customerPhone' => 'required|string|min:7|max:20',
            'paymentMethod' => 'required|in:pay_at_salon,online',
            'notes' => 'nullable|string|max:500',
        ]);

        $this->errorMessage = null;

        try {
            $appointment = $appointmentService->createAppointment([
                'service_id' => $this->selectedServiceId,
                'staff_id' => $this->selectedStaffId,
                'appointment_date' => $this->selectedDate,
                'start_time' => $this->selectedSlot,
                'customer_name' => $this->customerName,
                'customer_email' => $this->customerEmail,
                'customer_phone' => $this->customerPhone,
                'customer_id' => auth()->id(),
                'payment_method' => $this->paymentMethod,
                'notes' => $this->notes,
            ]);

            $this->confirmedAppointment = $appointment->load(['service', 'staff.staffProfile']);
            $this->currentStep = 5;
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function resetBooking(): void
    {
        $this->currentStep = 1;
        $this->selectedServiceId = null;
        $this->selectedStaffId = 'any';
        $this->selectedDate = Carbon::today()->format('Y-m-d');
        $this->selectedSlot = '';
        $this->selectedSlotLabel = '';
        $this->confirmedAppointment = null;
        $this->errorMessage = null;
    }

    public function render(BookingSlotService $slotService)
    {
        $categories = Category::where('is_active', true)
            ->with(['activeServices'])
            ->orderBy('order')
            ->get();

        $selectedService = $this->selectedServiceId ? Service::find($this->selectedServiceId) : null;

        // Staff options for chosen service
        $availableStaff = collect();
        if ($selectedService) {
            $availableStaff = $slotService->getEligibleStaffForService($selectedService);
        }

        // Calculate available time slots if on Step 3 or 4
        $availableSlots = [];
        if ($selectedService && $this->selectedDate) {
            $availableSlots = $slotService->getAvailableSlots(
                $selectedService->id,
                $this->selectedStaffId,
                $this->selectedDate
            );
        }

        $selectedStaffUser = ($this->selectedStaffId && $this->selectedStaffId !== 'any')
            ? User::with('staffProfile')->find($this->selectedStaffId)
            : null;

        // Generate next 14 days list for quick picker
        $dateOptions = [];
        for ($i = 0; $i < 14; $i++) {
            $d = Carbon::today()->addDays($i);
            $dateOptions[] = [
                'date' => $d->format('Y-m-d'),
                'day_name' => $d->format('D'),
                'day_number' => $d->format('d'),
                'month_name' => $d->format('M'),
                'is_today' => $d->isToday(),
            ];
        }

        return view('livewire.booking-wizard', [
            'categories' => $categories,
            'selectedService' => $selectedService,
            'availableStaff' => $availableStaff,
            'availableSlots' => $availableSlots,
            'selectedStaffUser' => $selectedStaffUser,
            'dateOptions' => $dateOptions,
        ]);
    }
}
