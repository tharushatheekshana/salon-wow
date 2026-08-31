<div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-neutral-900 dark:text-white">My Appointments</h1>
            <p class="text-neutral-500 text-sm mt-1">Logged in as <strong class="text-neutral-800 dark:text-neutral-200">{{ auth()->user()->name ?? 'Client' }}</strong> ({{ auth()->user()->email ?? '' }})</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
            <a href="{{ route('book') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-rose-600 text-white font-bold text-sm shadow-md hover:from-amber-600 hover:to-rose-700 transition">
                + Book New
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-rose-50 hover:text-rose-600 dark:hover:bg-neutral-800 text-sm font-bold transition">
                    Log out
                </button>
            </form>
        </div>
    </div>

    @if($notificationMessage)
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-sm font-medium">
            {{ $notificationMessage }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="flex gap-4 border-b border-neutral-200 dark:border-neutral-800 mb-6">
        <button
            wire:click="$set('activeTab', 'upcoming')"
            class="pb-3 text-sm font-bold border-b-2 transition-all {{ $activeTab === 'upcoming' ? 'border-rose-600 text-rose-600 dark:text-rose-400' : 'border-transparent text-neutral-500 hover:text-neutral-900 dark:hover:text-white' }}"
        >
            Upcoming ({{ $upcomingAppointments->count() }})
        </button>
        <button
            wire:click="$set('activeTab', 'past')"
            class="pb-3 text-sm font-bold border-b-2 transition-all {{ $activeTab === 'past' ? 'border-rose-600 text-rose-600 dark:text-rose-400' : 'border-transparent text-neutral-500 hover:text-neutral-900 dark:hover:text-white' }}"
        >
            Past & History ({{ $pastAppointments->count() }})
        </button>
    </div>

    <!-- UPCOMING APPOINTMENTS -->
    @if($activeTab === 'upcoming')
        @if($upcomingAppointments->isEmpty())
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-12 text-center">
                <div class="w-12 h-12 rounded-full bg-amber-50 dark:bg-amber-950 text-amber-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-bold text-neutral-900 dark:text-white text-base">No upcoming appointments</h3>
                <p class="text-xs text-neutral-500 mt-1 mb-4">Treat yourself today! Book your next hair or spa experience.</p>
                <a href="{{ route('book') }}" class="inline-block px-4 py-2 rounded-xl bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 text-xs font-bold">
                    Browse Services
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($upcomingAppointments as $apt)
                    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-6 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex items-start gap-4">
                            <img src="{{ $apt->staff->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($apt->staff->name) }}" class="w-14 h-14 rounded-2xl object-cover">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-rose-600 dark:text-rose-400">{{ $apt->booking_reference }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold ring-1 ring-inset {{ $apt->status_badge_class }}">
                                        {{ ucfirst($apt->status) }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mt-0.5">{{ $apt->service->name }}</h3>
                                <p class="text-xs text-neutral-500">Stylist: <span class="font-semibold text-neutral-700 dark:text-neutral-300">{{ $apt->staff->name }}</span> ({{ $apt->staff->staffProfile->title ?? 'Stylist' }})</p>
                                <p class="text-xs font-medium text-amber-600 dark:text-amber-400 mt-1">
                                    📅 {{ $apt->formatted_date }} &bull; ⏰ {{ $apt->formatted_start_time }} - {{ $apt->formatted_end_time }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-3 md:pt-0 border-neutral-100 dark:border-neutral-800">
                            <div class="text-right">
                                <span class="text-xs text-neutral-400 block">Total</span>
                                <span class="text-lg font-black text-neutral-900 dark:text-white">Rs. {{ number_format($apt->total_price, 2) }}</span>
                            </div>
                            <button
                                wire:click="openCancelModal({{ $apt->id }})"
                                class="px-3.5 py-2 text-xs font-bold text-rose-600 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 rounded-xl transition"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <!-- PAST APPOINTMENTS -->
    @if($activeTab === 'past')
        @if($pastAppointments->isEmpty())
            <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-12 text-center">
                <p class="text-sm text-neutral-500">No past appointment records found.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($pastAppointments as $apt)
                    <div class="bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-6 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-4 opacity-90">
                        <div class="flex items-start gap-4">
                            <img src="{{ $apt->staff->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($apt->staff->name) }}" class="w-12 h-12 rounded-xl object-cover">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-neutral-500">{{ $apt->booking_reference }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold ring-1 ring-inset {{ $apt->status_badge_class }}">
                                        {{ ucfirst($apt->status) }}
                                    </span>
                                </div>
                                <h3 class="text-base font-bold text-neutral-900 dark:text-white mt-0.5">{{ $apt->service->name }}</h3>
                                <p class="text-xs text-neutral-500">Stylist: {{ $apt->staff->name }} &bull; {{ $apt->formatted_date }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                            <span class="text-base font-bold text-neutral-900 dark:text-white">Rs. {{ number_format($apt->total_price, 2) }}</span>
                            
                            @if($apt->status === 'completed')
                                @if($apt->review)
                                    <span class="px-3 py-1.5 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 text-xs font-bold flex items-center gap-1">
                                        ★ {{ $apt->review->rating }} Reviewed
                                    </span>
                                @else
                                    <button
                                        wire:click="openReviewModal({{ $apt->id }})"
                                        class="px-3.5 py-2 text-xs font-bold text-amber-700 dark:text-amber-300 bg-amber-100 dark:bg-amber-950/60 rounded-xl hover:bg-amber-200 transition"
                                    >
                                        ★ Leave Review
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <!-- Cancel Modal -->
    @if($showCancelModal)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-neutral-200 dark:border-neutral-800">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Cancel Appointment</h3>
                <p class="text-xs text-neutral-500">Are you sure you want to cancel this booking? This action cannot be undone.</p>
                <textarea wire:model="cancellationReason" rows="2" placeholder="Optional reason..." class="w-full px-3 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-xs focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
                <div class="flex justify-end gap-2 pt-2">
                    <button wire:click="$set('showCancelModal', false)" class="px-4 py-2 text-xs font-bold text-neutral-500">Keep</button>
                    <button wire:click="confirmCancel" class="px-4 py-2 text-xs font-bold text-white bg-rose-600 rounded-xl shadow-md">Confirm Cancellation</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Review Modal -->
    @if($showReviewModal)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white dark:bg-neutral-900 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-neutral-200 dark:border-neutral-800">
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Review Your Experience</h3>
                <div class="flex items-center gap-2 justify-center py-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button wire:click="$set('rating', {{ $i }})" class="text-3xl transition-transform hover:scale-125 {{ $rating >= $i ? 'text-amber-400' : 'text-neutral-300 dark:text-neutral-700' }}">
                            ★
                        </button>
                    @endfor
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Your Feedback</label>
                    <textarea wire:model="reviewComment" rows="3" placeholder="Tell us what you liked about your treatment and stylist..." class="w-full px-3 py-2 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-xs focus:ring-2 focus:ring-rose-500 focus:outline-none"></textarea>
                    @error('reviewComment') <span class="text-rose-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button wire:click="$set('showReviewModal', false)" class="px-4 py-2 text-xs font-bold text-neutral-500">Cancel</button>
                    <button wire:click="submitReview" class="px-4 py-2 text-xs font-bold text-white bg-gradient-to-r from-amber-500 to-rose-600 rounded-xl shadow-md">Submit Review</button>
                </div>
            </div>
        </div>
    @endif
</div>
