<?php

use App\Models\User;

test('guests are redirected to login when visiting role-protected routes', function (string $routeName) {
    $this->get(route($routeName))->assertRedirect(route('login'));
})->with([
    'admin dashboard' => 'admin.dashboard',
    'admin services' => 'admin.services',
    'staff schedule' => 'staff.schedule',
]);

test('admins can access admin routes', function (string $routeName) {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route($routeName))
        ->assertOk();
})->with([
    'admin dashboard' => 'admin.dashboard',
    'admin services' => 'admin.services',
]);

test('non-admin roles are forbidden from admin routes', function (string $role, string $routeName) {
    $user = User::factory()->create(['role' => $role]);

    $this->actingAs($user)
        ->get(route($routeName))
        ->assertForbidden();
})->with([
    'customer on admin dashboard' => ['customer', 'admin.dashboard'],
    'customer on admin services' => ['customer', 'admin.services'],
    'staff on admin dashboard' => ['staff', 'admin.dashboard'],
    'staff on admin services' => ['staff', 'admin.services'],
]);

test('staff can access the staff schedule route', function () {
    $staff = User::factory()->create(['role' => 'staff']);

    $this->actingAs($staff)
        ->get(route('staff.schedule'))
        ->assertOk();
});

test('non-staff roles are forbidden from the staff schedule route', function (string $role) {
    $user = User::factory()->create(['role' => $role]);

    $this->actingAs($user)
        ->get(route('staff.schedule'))
        ->assertForbidden();
})->with([
    'customer' => 'customer',
    'admin' => 'admin',
]);
