<div class="max-w-3xl mx-auto px-4 sm:px-6 py-12">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight">Track Your Appointment</h1>
        <p class="text-neutral-500 text-sm mt-2">Enter your booking reference code (e.g. SLN-984210) to view appointment status, details, or manage your booking.</p>
    </div>

    <!-- Search Box -->
    <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-sm mb-8">
        <form wire:submit.prevent="search" class="flex flex-col sm:flex-row gap-3">
            <input
                type="text"
                wire:model="reference"
                placeholder="Enter Booking Reference (e.g. SLN-984210)"
                class="flex-1 px-4 py-3 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm font-semibold uppercase tracking-wider text-neutral-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:outline-none"
            >
            <button
                type="submit"
                class="px-6 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-rose-600 text-white font-bold text-sm shadow-md hover:from-amber-600 hover:to-rose-700 transition-all cursor-pointer"
            >
                Search Booking
            </button>
        </form>
    </div>

    @if($feedbackMessage)
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm font-medium text-center">
            {{ $feedbackMessage }}
        </div>
    @endif

    <!-- Search Results -->
    @if($searched)
        @if($appointment)
            <div class="bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200 dark:border-neutral-800 shadow-xl overflow-hidden">
                <!-- Header Status Bar -->
                <div class="p-6 bg-neutral-50 dark:bg-neutral-800/60 border-b border-neutral-200 dark:border-neutral-700 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-semibold text-neutral-400 uppercase tracking-wider">Booking Reference</span>
                        <h3 class="text-2xl font-black text-rose-600 dark:text-rose-400">{{ $appointment->booking_reference }}</h3>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset {{ $appointment->status_badge_class }}">
                            Status: {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                </div>

                <!-- Body Details -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-neutral-400 uppercase font-semibold">Service</span>
                                <h4 class="font-bold text-neutral-900 dark:text-white text-base">{{ $appointment->service->name }}</h4>
                                <p class="text-xs text-neutral-500">{{ $appointment->service->formatted_duration }} duration</p>
                            </div>

                            <div>
                                <span class="text-xs text-neutral-400 uppercase font-semibold">Specialist / Stylist</span>
                                <div class="flex items-center gap-3 mt-1">
                                    <img src="{{ $appointment->staff->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($appointment->staff->name) }}" class="w-10 h-10 rounded-full object-cover">
                                    <div>
                                        <p class="font-bold text-sm text-neutral-900 dark:text-white">{{ $appointment->staff->name }}</p>
                                        <p class="text-xs text-rose-600 dark:text-rose-400">{{ $appointment->staff->staffProfile->title ?? 'Stylist' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <span class="text-xs text-neutral-400 uppercase font-semibold">Appointment Time</span>
                                <p class="font-bold text-neutral-900 dark:text-white text-base">{{ $appointment->formatted_date }}</p>
                                <p class="text-sm font-semibold text-rose-600 dark:text-rose-400">{{ $appointment->formatted_start_time }} &ndash; {{ $appointment->formatted_end_time }}</p>
                            </div>

                            <div>
                                <span class="text-xs text-neutral-400 uppercase font-semibold">Payment & Pricing</span>
                                <p class="text-xl font-black text-neutral-900 dark:text-white">Rs. {{ number_format($appointment->total_price, 2) }}</p>
                                <p class="text-xs text-neutral-500">Method: {{ ucwords(str_replace('_', ' ', $appointment->payment_method)) }} ({{ ucfirst($appointment->payment_status) }})</p>
                            </div>
                        </div>
                    </div>

                    @if($appointment->notes)
                        <div class="p-4 rounded-xl bg-neutral-50 dark:bg-neutral-800/40 text-xs text-neutral-600 dark:text-neutral-300">
                            <span class="font-semibold text-neutral-900 dark:text-white">Customer Notes:</span> {{ $appointment->notes }}
                        </div>
                    @endif

                    <!-- Actions -->
                    @if(in_array($appointment->status, ['pending', 'confirmed']))
                        <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800 flex justify-end gap-3">
                            <button
                                wire:click="$set('showCancelModal', true)"
                                class="px-4 py-2 text-xs font-bold rounded-xl text-rose-600 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/60 transition"
                            >
                                Cancel Appointment
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="p-12 text-center bg-white dark:bg-neutral-900 rounded-3xl border border-neutral-200 dark:border-neutral-800">
                <div class="w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-950 text-rose-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white">No Appointment Found</h3>
                <p class="text-xs text-neutral-500 mt-1">Please double-check your booking reference number and try again.</p>
            </div>
        @endif
    @endif

    <!-- Cancel Confirmation Modal -->
    @if($showCancelModal && $appointment)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-neutral-200 dark:border-neutral-800 animate-scale-up">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Cancel Appointment?</h3>
                <p class="text-xs text-neutral-500">Are you sure you want to cancel booking <span class="font-bold text-rose-600">{{ $appointment->booking_reference }}</span>? This slot will become available for other clients.</p>
                
                <div>
                    <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Reason for cancellation (optional)</label>
                    <textarea wire:model="cancelReason" rows="2" placeholder="e.g. Schedule conflict..." class="w-full px-3 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-xs focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button wire:click="$set('showCancelModal', false)" class="px-4 py-2 text-xs font-bold text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-xl transition">
                        Keep Appointment
                    </button>
                    <button wire:click="cancelBooking" class="px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md transition">
                        Confirm Cancellation
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
