<div class="space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Staff Working Hours & Schedule</h1>
        <p class="text-xs text-neutral-500 mt-1">Configure your weekly working shifts, lunch breaks, and off days for appointment bookings.</p>
    </div>

    @if($feedbackMessage)
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-xs font-semibold">
            {{ $feedbackMessage }}
        </div>
    @endif

    <!-- Today's Personal Agenda -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-xs">
        <h3 class="font-bold text-sm text-neutral-900 dark:text-white mb-4">My Appointments Today ({{ \Carbon\Carbon::today()->format('l, M j') }})</h3>
        
        @if($todayAppointments->isEmpty())
            <p class="text-xs text-neutral-500">You have no appointments scheduled for today.</p>
        @else
            <div class="space-y-3">
                @foreach($todayAppointments as $apt)
                    <div class="p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200/60 dark:border-zinc-700/60 flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-rose-600 dark:text-rose-400">{{ $apt->formatted_start_time }} - {{ $apt->formatted_end_time }}</span>
                            <h4 class="font-bold text-sm text-neutral-900 dark:text-white mt-0.5">{{ $apt->service->name }}</h4>
                            <p class="text-xs text-neutral-500">Client: <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $apt->customer_name }}</span> ({{ $apt->customer_phone }})</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold ring-1 ring-inset {{ $apt->status_badge_class }}">
                            {{ ucfirst($apt->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Weekly Availability Settings Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-xs space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-bold text-sm text-neutral-900 dark:text-white">Weekly Working Schedule</h3>
            <button
                wire:click="saveSchedules"
                class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-rose-600 text-white font-bold text-xs shadow-md hover:from-amber-600 hover:to-rose-700 transition cursor-pointer"
            >
                Save Schedule Changes
            </button>
        </div>

        <div class="space-y-3 pt-2">
            @foreach($schedules as $id => $item)
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 flex flex-col md:flex-row md:items-center justify-between gap-4 {{ $item['is_day_off'] ? 'bg-zinc-100/50 dark:bg-zinc-800/20 opacity-60' : 'bg-white dark:bg-zinc-900' }}">
                    <div class="w-32">
                        <span class="font-bold text-sm text-neutral-900 dark:text-white">{{ $item['day_name'] }}</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-xs">
                        <label class="flex items-center gap-2 cursor-pointer font-semibold text-rose-600">
                            <input type="checkbox" wire:model.live="schedules.{{ $id }}.is_day_off" class="rounded text-rose-600 focus:ring-rose-500">
                            <span>Day Off</span>
                        </label>

                        @if(! $item['is_day_off'])
                            <div class="flex items-center gap-2">
                                <span class="text-neutral-500">Shift:</span>
                                <input type="time" wire:model="schedules.{{ $id }}.start_time" class="px-2 py-1 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                                <span>to</span>
                                <input type="time" wire:model="schedules.{{ $id }}.end_time" class="px-2 py-1 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="text-neutral-500">Break:</span>
                                <input type="time" wire:model="schedules.{{ $id }}.break_start_time" class="px-2 py-1 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                                <span>to</span>
                                <input type="time" wire:model="schedules.{{ $id }}.break_end_time" class="px-2 py-1 rounded-lg border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
