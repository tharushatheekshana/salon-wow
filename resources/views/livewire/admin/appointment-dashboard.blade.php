<div class="space-y-6">
    <!-- Header with Quick Action -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Salon Appointments Management</h1>
            <p class="text-xs text-neutral-500 mt-1">Live booking agenda, walk-in check-ins, and client scheduling overview.</p>
        </div>
        <button
            wire:click="openWalkInModal"
            class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-rose-600 text-white font-bold text-xs shadow-md hover:from-amber-600 hover:to-rose-700 transition flex items-center gap-1.5 cursor-pointer"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            + Fast Walk-in Booking
        </button>
    </div>

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs">
            <span class="text-xs font-semibold text-neutral-500 uppercase">Today's Bookings</span>
            <div class="flex items-center justify-between mt-2">
                <span class="text-3xl font-black text-neutral-900 dark:text-white">{{ $todayAppointmentsCount }}</span>
                <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs">
            <span class="text-xs font-semibold text-neutral-500 uppercase">Pending Approval</span>
            <div class="flex items-center justify-between mt-2">
                <span class="text-3xl font-black text-amber-500">{{ $pendingCount }}</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs">
            <span class="text-xs font-semibold text-neutral-500 uppercase">Monthly Revenue</span>
            <div class="flex items-center justify-between mt-2">
                <span class="text-3xl font-black text-emerald-600">Rs. {{ number_format($completedThisMonth, 2) }}</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xs">
            <span class="text-xs font-semibold text-neutral-500 uppercase">Active Stylists</span>
            <div class="flex items-center justify-between mt-2">
                <span class="text-3xl font-black text-neutral-900 dark:text-white">{{ $activeStylistsCount }}</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    @if($feedbackMessage)
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-xs font-semibold">
            {{ $feedbackMessage }}
        </div>
    @endif

    <!-- Filter Toolbar -->
    <div class="p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex flex-wrap items-center justify-between gap-3">
        <div class="flex-1 min-w-[200px]">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search reference, client name, phone..."
                class="w-full px-3.5 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-neutral-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500"
            >
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Status Filter -->
            <select wire:model.live="statusFilter" class="px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-neutral-900 dark:text-white focus:outline-none">
                <option value="all">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <!-- Stylist Filter -->
            <select wire:model.live="staffFilter" class="px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-neutral-900 dark:text-white focus:outline-none">
                <option value="all">All Stylists</option>
                @foreach($allStaff as $st)
                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                @endforeach
            </select>

            <!-- Date Filter -->
            <input
                type="date"
                wire:model.live="dateFilter"
                class="px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs text-neutral-900 dark:text-white focus:outline-none"
            >
            @if($dateFilter)
                <button wire:click="$set('dateFilter', '')" class="text-xs text-neutral-400 hover:text-neutral-600">Clear Date</button>
            @endif
        </div>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-zinc-50 dark:bg-zinc-800/60 text-neutral-500 uppercase font-semibold border-b border-zinc-200 dark:border-zinc-700">
                    <tr>
                        <th class="px-5 py-3.5">Ref #</th>
                        <th class="px-5 py-3.5">Customer</th>
                        <th class="px-5 py-3.5">Service</th>
                        <th class="px-5 py-3.5">Stylist</th>
                        <th class="px-5 py-3.5">Date & Time</th>
                        <th class="px-5 py-3.5">Amount</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($appointments as $apt)
                        <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition-colors">
                            <td class="px-5 py-4 font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">
                                {{ $apt->booking_reference }}
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-bold text-neutral-900 dark:text-white">{{ $apt->customer_name }}</p>
                                <p class="text-[11px] text-neutral-500">{{ $apt->customer_phone }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $apt->service->name }}</p>
                                <p class="text-[11px] text-neutral-500">{{ $apt->duration_minutes }} mins</p>
                            </td>
                            <td class="px-5 py-4 font-medium text-neutral-700 dark:text-neutral-300">
                                {{ $apt->staff->name }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <p class="font-semibold text-neutral-900 dark:text-white">{{ $apt->formatted_date }}</p>
                                <p class="text-[11px] text-rose-600 dark:text-rose-400 font-medium">{{ $apt->formatted_start_time }} &ndash; {{ $apt->formatted_end_time }}</p>
                            </td>
                            <td class="px-5 py-4 font-bold text-neutral-900 dark:text-white">
                                Rs. {{ number_format($apt->total_price, 2) }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold ring-1 ring-inset {{ $apt->status_badge_class }}">
                                    {{ ucfirst($apt->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right space-x-1 whitespace-nowrap">
                                @if($apt->status === 'confirmed')
                                    <button
                                        wire:click="quickStatusUpdate({{ $apt->id }}, 'completed')"
                                        title="Mark Completed"
                                        class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300 hover:bg-emerald-100 font-semibold"
                                    >
                                        ✓ Complete
                                    </button>
                                @endif
                                <button
                                    wire:click="openStatusModal({{ $apt->id }})"
                                    class="px-2.5 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-neutral-700 dark:text-neutral-300 hover:bg-zinc-200 font-semibold"
                                >
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-neutral-500">
                                No appointments found matching your search and filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
            {{ $appointments->links() }}
        </div>
    </div>

    <!-- Walk-in Booking Modal -->
    @if($showWalkInModal)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-zinc-100 dark:border-zinc-800 pb-3">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Fast Walk-in Booking</h3>
                    <button wire:click="$set('showWalkInModal', false)" class="text-neutral-400 hover:text-neutral-600">&times;</button>
                </div>

                @if($walkInError)
                    <div class="p-3 rounded-xl bg-rose-50 text-rose-700 text-xs font-semibold">
                        {{ $walkInError }}
                    </div>
                @endif

                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Service *</label>
                        <select wire:model.live="walkInServiceId" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs">
                            @foreach($allServices as $svc)
                                <option value="{{ $svc->id }}">{{ $svc->name }} (Rs. {{ number_format($svc->price, 2) }} - {{ $svc->duration_minutes }}m)</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1">Stylist *</label>
                        <select wire:model.live="walkInStaffId" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs">
                            @foreach($allStaff as $st)
                                <option value="{{ $st->id }}">{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold mb-1">Date *</label>
                            <input type="date" wire:model.live="walkInDate" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold mb-1">Time Slot *</label>
                            <select wire:model="walkInSlot" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs">
                                <option value="">Select Time Slot</option>
                                @foreach($walkInSlots as $slot)
                                    <option value="{{ $slot['start_time'] }}">{{ $slot['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1">Client Name *</label>
                        <input type="text" wire:model="walkInCustomerName" placeholder="Client Name" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold mb-1">Client Phone *</label>
                            <input type="tel" wire:model="walkInCustomerPhone" placeholder="+1..." class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold mb-1">Email (Optional)</label>
                            <input type="email" wire:model="walkInCustomerEmail" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-xs">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                    <button wire:click="$set('showWalkInModal', false)" class="px-4 py-2 text-xs font-bold text-neutral-500">Cancel</button>
                    <button wire:click="createWalkIn" class="px-5 py-2 text-xs font-bold text-white bg-gradient-to-r from-amber-500 to-rose-600 rounded-xl shadow-md">Book Walk-in</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Status & Payment Edit Modal -->
    @if($showStatusModal && $selectedAppointment)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800">
                <h3 class="text-base font-bold text-neutral-900 dark:text-white">
                    Update Appointment <span class="text-rose-600">{{ $selectedAppointment->booking_reference }}</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div>
                        <label class="block font-semibold mb-1">Appointment Status</label>
                        <select wire:model="newStatus" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="no_show">No Show</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Payment Status</label>
                        <select wire:model="newPaymentStatus" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            <option value="pay_at_salon">Pay at Salon</option>
                            <option value="paid">Paid</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3">
                    <button wire:click="$set('showStatusModal', false)" class="px-4 py-2 text-xs font-bold text-neutral-500">Cancel</button>
                    <button wire:click="updateAppointmentStatus" class="px-5 py-2 text-xs font-bold text-white bg-neutral-900 dark:bg-white dark:text-neutral-900 rounded-xl">Save Changes</button>
                </div>
            </div>
        </div>
    @endif
</div>
