<?php

use App\Livewire\Admin\AppointmentDashboard;
use App\Livewire\BookingLookup;
use App\Livewire\BookingWizard;
use App\Livewire\CustomerAppointments;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use App\Services\AppointmentService;
use App\Services\BookingSlotService;
use Carbon\Carbon;
use Database\Seeders\SalonDatabaseSeeder;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(SalonDatabaseSeeder::class);
});

test('public landing page renders successfully with salon services', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('SALON');
    $response->assertSee('WOW');
    $response->assertSee('Executive Gents Cut & Beard Trim');
});

test('booking wizard renders and can cycle through steps', function () {
    $service = Service::first();

    Livewire::test(BookingWizard::class)
        ->assertSet('currentStep', 1)
        ->call('selectService', $service->id)
        ->assertSet('currentStep', 2)
        ->assertSet('selectedServiceId', $service->id)
        ->call('selectStaff', 'any')
        ->assertSet('currentStep', 3);
});

test('booking slot service computes available slots accurately', function () {
    $slotService = app(BookingSlotService::class);
    $service = Service::first();
    $staff = User::where('role', 'staff')->first();

    // Pick next Monday
    $nextMonday = Carbon::now()->next(Carbon::MONDAY)->toDateString();

    $slots = $slotService->getAvailableSlots($service->id, $staff->id, $nextMonday);

    expect($slots)->toBeArray();
    expect(count($slots))->toBeGreaterThan(0);
    expect($slots[0])->toHaveKeys(['start_time', 'end_time', 'formatted_start', 'formatted_end', 'label', 'staff_id', 'staff_name']);
});

test('customer can successfully book an appointment via wizard', function () {
    $service = Service::first();
    $staff = User::where('role', 'staff')->first();
    $targetDate = Carbon::now()->next(Carbon::TUESDAY)->toDateString();

    Livewire::test(BookingWizard::class)
        ->set('selectedServiceId', $service->id)
        ->set('selectedStaffId', $staff->id)
        ->set('selectedDate', $targetDate)
        ->set('selectedSlot', '10:00:00')
        ->set('selectedSlotLabel', '10:00 AM - 11:00 AM')
        ->set('customerName', 'Emily Watson')
        ->set('customerEmail', 'emily@example.com')
        ->set('customerPhone', '+1 555-492-9102')
        ->set('paymentMethod', 'pay_at_salon')
        ->call('confirmBooking')
        ->assertSet('currentStep', 5)
        ->assertHasNoErrors();

    $this->assertDatabaseHas('appointments', [
        'customer_name' => 'Emily Watson',
        'customer_email' => 'emily@example.com',
        'service_id' => $service->id,
        'staff_id' => $staff->id,
        'start_time' => '10:00:00',
    ]);
});

test('double booking is prevented on the same slot for the same stylist', function () {
    $appointmentService = app(AppointmentService::class);
    $service = Service::first();
    $staff = User::where('role', 'staff')->first();
    $targetDate = Carbon::now()->next(Carbon::WEDNESDAY)->toDateString();

    // First booking
    $appointmentService->createAppointment([
        'service_id' => $service->id,
        'staff_id' => $staff->id,
        'appointment_date' => $targetDate,
        'start_time' => '11:00:00',
        'customer_name' => 'Client One',
        'customer_email' => 'client1@example.com',
        'customer_phone' => '+1 555-111-2222',
    ]);

    // Second booking on exact same time should throw Exception
    expect(fn () => $appointmentService->createAppointment([
        'service_id' => $service->id,
        'staff_id' => $staff->id,
        'appointment_date' => $targetDate,
        'start_time' => '11:00:00',
        'customer_name' => 'Client Two',
        'customer_email' => 'client2@example.com',
        'customer_phone' => '+1 555-333-4444',
    ]))->toThrow(Exception::class);
});

test('public booking tracker finds appointment by reference', function () {
    $appointment = Appointment::first();

    Livewire::test(BookingLookup::class)
        ->set('reference', $appointment->booking_reference)
        ->call('search')
        ->assertSet('searched', true)
        ->assertSee($appointment->booking_reference)
        ->assertSee($appointment->service->name);
});

test('authenticated customer can view and cancel appointment', function () {
    $customer = User::where('email', 'customer@example.com')->first();
    $appointment = Appointment::where('customer_id', $customer->id)->where('status', 'confirmed')->first();

    $this->actingAs($customer);

    Livewire::test(CustomerAppointments::class)
        ->call('openCancelModal', $appointment->id)
        ->set('cancellationReason', 'Rescheduling needed')
        ->call('confirmCancel');

    expect($appointment->fresh()->status)->toBe('cancelled');
});

test('admin can view appointment dashboard and update appointment status', function () {
    $admin = User::where('email', 'admin@salonwow.lk')->first();
    $appointment = Appointment::first();

    $this->actingAs($admin);

    Livewire::test(AppointmentDashboard::class)
        ->assertSee('Salon Appointments Management')
        ->call('quickStatusUpdate', $appointment->id, 'completed');

    expect($appointment->fresh()->status)->toBe('completed');
});
