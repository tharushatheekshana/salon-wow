<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Services\AppointmentService;
use App\Services\BookingSlotService;
use Carbon\Carbon;
use Exception;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class AppointmentDashboard extends Component
{
    use WithPagination;

    // Filters
    public string $search = '';

    public string $statusFilter = 'all'; // all, confirmed, pending, completed, cancelled

    public string $dateFilter = ''; // Y-m-d or empty

    public string $staffFilter = 'all';

    // Walk-in booking modal
    public bool $showWalkInModal = false;

    public ?int $walkInServiceId = null;

    public ?int $walkInStaffId = null;

    public string $walkInDate = '';

    public string $walkInSlot = '';

    public string $walkInCustomerName = '';

    public string $walkInCustomerEmail = '';

    public string $walkInCustomerPhone = '';

    public string $walkInNotes = '';

    public ?string $walkInError = null;

    // Edit Status modal
    public bool $showStatusModal = false;

    public ?Appointment $selectedAppointment = null;

    public string $newStatus = '';

    public string $newPaymentStatus = '';

    public ?string $feedbackMessage = null;

    public function mount(): void
    {
        $this->walkInDate = Carbon::today()->format('Y-m-d');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openStatusModal(int $appointmentId): void
    {
        $this->selectedAppointment = Appointment::find($appointmentId);
        if ($this->selectedAppointment) {
            $this->newStatus = $this->selectedAppointment->status;
            $this->newPaymentStatus = $this->selectedAppointment->payment_status;
            $this->showStatusModal = true;
        }
    }

    public function updateAppointmentStatus(): void
    {
        if (! $this->selectedAppointment) {
            return;
        }

        $this->selectedAppointment->update([
            'status' => $this->newStatus,
            'payment_status' => $this->newPaymentStatus,
        ]);

        $this->showStatusModal = false;
        $this->feedbackMessage = "Appointment {$this->selectedAppointment->booking_reference} updated successfully.";
    }

    public function quickStatusUpdate(int $appointmentId, string $status): void
    {
        $apt = Appointment::find($appointmentId);
        if ($apt) {
            $apt->update(['status' => $status]);
            $this->feedbackMessage = "Appointment {$apt->booking_reference} marked as {$status}.";
        }
    }

    public function openWalkInModal(): void
    {
        $this->walkInDate = Carbon::today()->format('Y-m-d');
        $this->walkInServiceId = Service::where('is_active', true)->first()->id ?? null;
        $this->walkInStaffId = User::where('role', 'staff')->first()->id ?? null;
        $this->walkInSlot = '';
        $this->walkInCustomerName = '';
        $this->walkInCustomerEmail = 'walkin@salon.com';
        $this->walkInCustomerPhone = '';
        $this->walkInNotes = 'Walk-in Client';
        $this->walkInError = null;
        $this->showWalkInModal = true;
    }

    public function createWalkIn(AppointmentService $appointmentService): void
    {
        $this->validate([
            'walkInServiceId' => 'required|exists:services,id',
            'walkInStaffId' => 'required|exists:users,id',
            'walkInDate' => 'required|date',
            'walkInSlot' => 'required',
            'walkInCustomerName' => 'required|string|min:2',
            'walkInCustomerPhone' => 'required|string|min:7',
        ]);

        $this->walkInError = null;

        try {
            $appointmentService->createAppointment([
                'service_id' => $this->walkInServiceId,
                'staff_id' => $this->walkInStaffId,
                'appointment_date' => $this->walkInDate,
                'start_time' => $this->walkInSlot,
                'customer_name' => $this->walkInCustomerName,
                'customer_email' => $this->walkInCustomerEmail,
                'customer_phone' => $this->walkInCustomerPhone,
                'payment_method' => 'cash',
                'notes' => $this->walkInNotes,
            ]);

            $this->showWalkInModal = false;
            $this->feedbackMessage = 'Walk-in appointment recorded successfully!';
        } catch (Exception $e) {
            $this->walkInError = $e->getMessage();
        }
    }

    public function render(BookingSlotService $slotService)
    {
        $query = Appointment::with(['service', 'staff.staffProfile', 'customer'])
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('booking_reference', 'like', "%{$this->search}%")
                        ->orWhere('customer_name', 'like', "%{$this->search}%")
                        ->orWhere('customer_phone', 'like', "%{$this->search}%")
                        ->orWhere('customer_email', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter !== 'all', function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->when($this->dateFilter, function ($q) {
                $q->whereDate('appointment_date', $this->dateFilter);
            })
            ->when($this->staffFilter !== 'all', function ($q) {
                $q->where('staff_id', $this->staffFilter);
            })
            ->orderByDesc('appointment_date')
            ->orderBy('start_time');

        $appointments = $query->paginate(15);

        // Calculate KPI Metrics
        $todayAppointmentsCount = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $pendingCount = Appointment::where('status', 'pending')->count();
        $completedThisMonth = Appointment::where('status', 'completed')
            ->whereMonth('appointment_date', Carbon::now()->month)
            ->sum('total_price');
        $activeStylistsCount = User::where('role', 'staff')->count();

        $allStaff = User::where('role', 'staff')->orderBy('name')->get();
        $allServices = Service::where('is_active', true)->orderBy('name')->get();

        // Walk-in available slots
        $walkInSlots = [];
        if ($this->showWalkInModal && $this->walkInServiceId && $this->walkInStaffId && $this->walkInDate) {
            $walkInSlots = $slotService->getAvailableSlots(
                $this->walkInServiceId,
                $this->walkInStaffId,
                $this->walkInDate
            );
        }

        return view('livewire.admin.appointment-dashboard', [
            'appointments' => $appointments,
            'todayAppointmentsCount' => $todayAppointmentsCount,
            'pendingCount' => $pendingCount,
            'completedThisMonth' => $completedThisMonth,
            'activeStylistsCount' => $activeStylistsCount,
            'allStaff' => $allStaff,
            'allServices' => $allServices,
            'walkInSlots' => $walkInSlots,
        ]);
    }
}
