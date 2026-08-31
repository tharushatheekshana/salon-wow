<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Stepper Navigation -->
    <div class="mb-10">
        <div class="flex items-center justify-between max-w-3xl mx-auto">
            <!-- Step 1 Indicator -->
            <button wire:click="goToStep(1)" @disabled($currentStep < 1) class="flex items-center gap-2 text-left group focus:outline-none">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all {{ $currentStep === 1 ? 'bg-gradient-to-r from-amber-500 to-rose-600 text-white shadow-lg shadow-rose-500/30 ring-4 ring-rose-500/20' : ($currentStep > 1 ? 'bg-emerald-500 text-white' : 'bg-neutral-200 dark:bg-neutral-800 text-neutral-500') }}">
                    @if($currentStep > 1)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                        1
                    @endif
                </div>
                <div class="hidden sm:block">
                    <span class="text-xs uppercase tracking-wider font-semibold text-neutral-400">Step 1</span>
                    <p class="text-sm font-semibold {{ $currentStep === 1 ? 'text-rose-600 dark:text-rose-400' : 'text-neutral-700 dark:text-neutral-300' }}">Service</p>
                </div>
            </button>

            <div class="flex-1 h-0.5 mx-3 bg-neutral-200 dark:bg-neutral-800 {{ $currentStep > 1 ? 'bg-emerald-500 dark:bg-emerald-500' : '' }}"></div>

            <!-- Step 2 Indicator -->
            <button wire:click="goToStep(2)" @disabled($currentStep < 2) class="flex items-center gap-2 text-left group focus:outline-none">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all {{ $currentStep === 2 ? 'bg-gradient-to-r from-amber-500 to-rose-600 text-white shadow-lg shadow-rose-500/30 ring-4 ring-rose-500/20' : ($currentStep > 2 ? 'bg-emerald-500 text-white' : 'bg-neutral-200 dark:bg-neutral-800 text-neutral-500') }}">
                    @if($currentStep > 2)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                        2
                    @endif
                </div>
                <div class="hidden sm:block">
                    <span class="text-xs uppercase tracking-wider font-semibold text-neutral-400">Step 2</span>
                    <p class="text-sm font-semibold {{ $currentStep === 2 ? 'text-rose-600 dark:text-rose-400' : 'text-neutral-700 dark:text-neutral-300' }}">Stylist</p>
                </div>
            </button>

            <div class="flex-1 h-0.5 mx-3 bg-neutral-200 dark:bg-neutral-800 {{ $currentStep > 2 ? 'bg-emerald-500 dark:bg-emerald-500' : '' }}"></div>

            <!-- Step 3 Indicator -->
            <button wire:click="goToStep(3)" @disabled($currentStep < 3) class="flex items-center gap-2 text-left group focus:outline-none">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all {{ $currentStep === 3 ? 'bg-gradient-to-r from-amber-500 to-rose-600 text-white shadow-lg shadow-rose-500/30 ring-4 ring-rose-500/20' : ($currentStep > 3 ? 'bg-emerald-500 text-white' : 'bg-neutral-200 dark:bg-neutral-800 text-neutral-500') }}">
                    @if($currentStep > 3)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                        3
                    @endif
                </div>
                <div class="hidden sm:block">
                    <span class="text-xs uppercase tracking-wider font-semibold text-neutral-400">Step 3</span>
                    <p class="text-sm font-semibold {{ $currentStep === 3 ? 'text-rose-600 dark:text-rose-400' : 'text-neutral-700 dark:text-neutral-300' }}">Date & Time</p>
                </div>
            </button>

            <div class="flex-1 h-0.5 mx-3 bg-neutral-200 dark:bg-neutral-800 {{ $currentStep > 3 ? 'bg-emerald-500 dark:bg-emerald-500' : '' }}"></div>

            <!-- Step 4 Indicator -->
            <button wire:click="goToStep(4)" @disabled($currentStep < 4) class="flex items-center gap-2 text-left group focus:outline-none">
                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all {{ $currentStep === 4 ? 'bg-gradient-to-r from-amber-500 to-rose-600 text-white shadow-lg shadow-rose-500/30 ring-4 ring-rose-500/20' : ($currentStep > 4 ? 'bg-emerald-500 text-white' : 'bg-neutral-200 dark:bg-neutral-800 text-neutral-500') }}">
                    @if($currentStep > 4)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                        4
                    @endif
                </div>
                <div class="hidden sm:block">
                    <span class="text-xs uppercase tracking-wider font-semibold text-neutral-400">Step 4</span>
                    <p class="text-sm font-semibold {{ $currentStep === 4 ? 'text-rose-600 dark:text-rose-400' : 'text-neutral-700 dark:text-neutral-300' }}">Review</p>
                </div>
            </button>
        </div>
    </div>

    <!-- Error Alert Message -->
    @if($errorMessage)
        <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 flex items-center gap-3 text-rose-700 dark:text-rose-300 animate-fade-in">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm font-medium">{{ $errorMessage }}</p>
        </div>
    @endif

    <!-- STEP 1: SELECT SERVICE -->
    @if($currentStep === 1)
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 dark:border-neutral-800 pb-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-rose-600 dark:text-rose-400">Step 1 of 4</span>
                    <h2 class="text-3xl font-extrabold text-neutral-900 dark:text-white tracking-tight mt-1">Select a Treatment</h2>
                    <p class="text-neutral-500 dark:text-neutral-400 mt-1 text-sm">Choose from our unisex hair styling, luxury facials, and bridal care.</p>
                </div>

                <!-- Search Input -->
                <div class="w-full md:w-72">
                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live.debounce.250ms="searchService"
                            placeholder="Search treatments..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-xs text-neutral-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:outline-none shadow-xs"
                        >
                        <svg class="w-4 h-4 text-neutral-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Two-Column Layout: Left Category Filter Sidebar + Right Services Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- LEFT SIDEBAR: CATEGORY FILTER BAR -->
                <aside class="lg:col-span-3 lg:sticky lg:top-28 space-y-3">
                    <div class="bg-white dark:bg-neutral-900 p-4 rounded-2xl border border-neutral-200/80 dark:border-neutral-800 shadow-xs">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-400 mb-3 px-2">Filter Categories</h3>
                        
                        <nav class="space-y-1.5 flex flex-row lg:flex-col overflow-x-auto pb-2 lg:pb-0">
                            <!-- All Treatments -->
                            <button
                                wire:click="selectCategory(null)"
                                class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all text-left whitespace-nowrap lg:whitespace-normal cursor-pointer {{ is_null($selectedCategoryId) ? 'bg-gradient-to-r from-amber-500 to-rose-600 text-white shadow-md shadow-rose-500/20' : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}"
                            >
                                <span class="flex items-center gap-2">
                                    <span>✨</span>
                                    <span>All Treatments</span>
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] {{ is_null($selectedCategoryId) ? 'bg-white/20 text-white' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-500' }}">
                                    {{ $categories->sum(fn($c) => $c->activeServices->count()) }}
                                </span>
                            </button>

                            <!-- Individual Categories -->
                            @foreach($categories as $category)
                                <button
                                    wire:key="cat-filter-{{ $category->id }}"
                                    wire:click="selectCategory({{ $category->id }})"
                                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all text-left whitespace-nowrap lg:whitespace-normal cursor-pointer {{ $selectedCategoryId === $category->id ? 'bg-gradient-to-r from-amber-500 to-rose-600 text-white shadow-md shadow-rose-500/20' : 'text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800' }}"
                                >
                                    <span class="flex items-center gap-2">
                                        <span>
                                            @if($category->slug === 'gents-hair-grooming') ✂️
                                            @elseif($category->slug === 'ladies-hair-styling-treatments') 💇‍♀️
                                            @elseif($category->slug === 'bridal-event-dressing') 👰
                                            @elseif($category->slug === 'facials-skin-care') 💆‍♀️
                                            @else 🌸
                                            @endif
                                        </span>
                                        <span>{{ $category->name }}</span>
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $selectedCategoryId === $category->id ? 'bg-white/20 text-white' : 'bg-neutral-100 dark:bg-neutral-800 text-neutral-500' }}">
                                        {{ $category->activeServices->count() }}
                                    </span>
                                </button>
                            @endforeach
                        </nav>
                    </div>

                    <!-- Left Sidebar Salon WOW Assistance Card -->
                    <div class="hidden lg:block bg-gradient-to-br from-amber-500/10 to-rose-500/10 border border-amber-500/20 dark:border-rose-500/20 p-4 rounded-2xl">
                        <div class="flex items-center gap-3">
                            <img src="/images/salon-wow-logo.jpg" alt="Salon WOW" class="w-10 h-10 rounded-xl object-cover border border-amber-500/30">
                            <div>
                                <h4 class="font-bold text-xs text-neutral-900 dark:text-white">Salon WOW</h4>
                                <p class="text-[10px] text-neutral-500">Pambahinna &bull; Belihuloya</p>
                            </div>
                        </div>
                        <p class="text-[11px] text-neutral-600 dark:text-neutral-300 mt-2.5 leading-relaxed">
                            Need help selecting a treatment or custom bridal appointment?
                        </p>
                        <a href="tel:0711544071" class="mt-2.5 inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 dark:text-rose-400 hover:underline">
                            📞 071 154 4071
                        </a>
                    </div>
                </aside>

                <!-- RIGHT MAIN CONTENT: SERVICES GRID -->
                <div class="lg:col-span-9 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php $hasServices = false; @endphp
                        @foreach($categories as $category)
                            @if(is_null($selectedCategoryId) || $selectedCategoryId === $category->id)
                                @foreach($category->activeServices as $service)
                                    @if(empty($searchService) || str_contains(strtolower($service->name), strtolower($searchService)) || str_contains(strtolower($service->description), strtolower($searchService)))
                                        @php $hasServices = true; @endphp
                                        <div
                                            wire:key="service-{{ $service->id }}"
                                            wire:click="selectService({{ $service->id }})"
                                            class="group bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200/80 dark:border-neutral-800 overflow-hidden shadow-xs hover:shadow-xl hover:border-amber-500/50 dark:hover:border-amber-500/50 transition-all duration-300 cursor-pointer flex flex-col justify-between hover:-translate-y-1"
                                        >
                                            @if($service->image_url)
                                                <div class="relative h-44 w-full overflow-hidden bg-neutral-100 dark:bg-neutral-800">
                                                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                    <div class="absolute top-3 right-3 bg-neutral-900/80 backdrop-blur-md text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                                                        {{ $service->formatted_duration }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="p-5 flex-1 flex flex-col justify-between">
                                                <div>
                                                    <span class="text-[11px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">{{ $category->name }}</span>
                                                    <h3 class="text-base font-bold text-neutral-900 dark:text-white mt-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                                                        {{ $service->name }}
                                                    </h3>
                                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1.5 line-clamp-2 leading-relaxed">
                                                        {{ $service->description }}
                                                    </p>
                                                </div>

                                                <div class="mt-5 pt-3.5 border-t border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                                                    <span class="text-lg font-black text-neutral-900 dark:text-white">
                                                        Rs. {{ number_format($service->price, 2) }}
                                                    </span>
                                                    <button class="px-3.5 py-1.5 text-xs font-semibold rounded-xl bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 group-hover:bg-gradient-to-r group-hover:from-amber-500 group-hover:to-rose-600 group-hover:text-white transition-all shadow-xs">
                                                        Select &rarr;
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if(!$hasServices)
                            <div class="col-span-full bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800 p-12 text-center">
                                <p class="text-neutral-500 text-sm">No treatments found matching your filter or search keyword.</p>
                                <button wire:click="$set('searchService', ''); $set('selectedCategoryId', null);" class="mt-3 text-xs font-bold text-rose-600 hover:underline">
                                    Clear filters & view all
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- STEP 2: SELECT STYLIST -->
    @if($currentStep === 2)
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-4">
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Choose Your Specialist</h2>
                    <p class="text-neutral-500 text-xs mt-1">For: <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $selectedService->name }} ({{ $selectedService->formatted_duration }} &bull; Rs. {{ number_format($selectedService->price, 2) }})</span></p>
                </div>
                <button wire:click="goToStep(1)" class="text-xs font-medium text-neutral-500 hover:text-neutral-900 dark:hover:text-white flex items-center gap-1">
                    &larr; Change Service
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <!-- Any Specialist Card -->
                <div
                    wire:click="selectStaff('any')"
                    class="p-5 rounded-2xl border-2 transition-all cursor-pointer flex items-center gap-4 {{ $selectedStaffId === 'any' ? 'border-amber-500 bg-amber-50/50 dark:bg-amber-950/20 shadow-md ring-2 ring-amber-500/20' : 'border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 hover:border-neutral-300 dark:hover:border-neutral-700' }}"
                >
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-500 to-rose-500 text-white flex items-center justify-center shadow-md">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-neutral-900 dark:text-white">Any Available Specialist</h4>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">We will assign the best matching specialist available for your preferred time.</p>
                        <span class="inline-block mt-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">Fastest Availability</span>
                    </div>
                </div>

                <!-- Individual Staff Members -->
                @foreach($availableStaff as $staff)
                    <div
                        wire:key="staff-{{ $staff->id }}"
                        wire:click="selectStaff({{ $staff->id }})"
                        class="p-5 rounded-2xl border-2 transition-all cursor-pointer flex items-center gap-4 {{ $selectedStaffId == $staff->id ? 'border-amber-500 bg-amber-50/50 dark:bg-amber-950/20 shadow-md ring-2 ring-amber-500/20' : 'border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 hover:border-neutral-300 dark:hover:border-neutral-700' }}"
                    >
                        <img src="{{ $staff->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($staff->name) }}" alt="{{ $staff->name }}" class="w-14 h-14 rounded-2xl object-cover shadow-sm">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="font-bold text-neutral-900 dark:text-white truncate">{{ $staff->name }}</h4>
                                <span class="flex items-center text-xs font-semibold text-amber-500">
                                    ★ {{ number_format($staff->staffProfile->rating ?? 5.0, 1) }}
                                </span>
                            </div>
                            <p class="text-xs font-medium text-rose-600 dark:text-rose-400 truncate">{{ $staff->staffProfile->title ?? 'Stylist' }}</p>
                            <p class="text-[11px] text-neutral-500 dark:text-neutral-400 truncate mt-1">{{ $staff->staffProfile->bio ?? 'Dedicated beauty specialist.' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- STEP 3: SELECT DATE & TIME SLOT -->
    @if($currentStep === 3)
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-4">
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white">Choose Date & Time</h2>
                    <p class="text-neutral-500 text-xs mt-1">
                        Stylist: <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $selectedStaffId === 'any' ? 'Any Available Specialist' : ($selectedStaffUser->name ?? 'Stylist') }}</span> &bull;
                        Service: <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $selectedService->name }}</span>
                    </p>
                </div>
                <button wire:click="goToStep(2)" class="text-xs font-medium text-neutral-500 hover:text-neutral-900 dark:hover:text-white flex items-center gap-1">
                    &larr; Change Specialist
                </button>
            </div>

            <!-- Date Selector (Next 14 Days Pills) -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-neutral-500 mb-3">Select Date</label>
                <div class="flex items-center gap-3 overflow-x-auto pb-3">
                    @foreach($dateOptions as $opt)
                        <button
                            wire:click="selectDate('{{ $opt['date'] }}')"
                            class="flex flex-col items-center justify-center p-3 min-w-[72px] rounded-2xl border-2 transition-all {{ $selectedDate === $opt['date'] ? 'border-rose-600 bg-rose-50 dark:bg-rose-950/30 text-rose-600 dark:text-rose-400 font-bold shadow-md' : 'border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-900 text-neutral-700 dark:text-neutral-300 hover:border-neutral-300' }}"
                        >
                            <span class="text-[10px] uppercase font-bold text-neutral-400">{{ $opt['day_name'] }}</span>
                            <span class="text-xl font-extrabold mt-0.5">{{ $opt['day_number'] }}</span>
                            <span class="text-[10px] font-medium text-neutral-400">{{ $opt['month_name'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Time Slots Grid -->
            <div class="pt-4">
                <div class="flex items-center justify-between mb-4">
                    <label class="block text-xs font-bold uppercase tracking-wider text-neutral-500">
                        Available Time Slots for {{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}
                    </label>
                    <span class="text-xs text-neutral-400" wire:loading.delay>Calculating availability...</span>
                </div>

                @if(empty($availableSlots))
                    <div class="p-8 text-center bg-white dark:bg-neutral-900 rounded-2xl border border-neutral-200 dark:border-neutral-800">
                        <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-950 text-amber-600 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-neutral-800 dark:text-neutral-200">No Available Slots on this Date</h4>
                        <p class="text-xs text-neutral-500 mt-1">Please choose another date or select "Any Available Specialist" to see more times.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach($availableSlots as $slot)
                            <button
                                wire:key="slot-{{ $slot['start_time'] }}"
                                wire:click="selectSlot('{{ $slot['start_time'] }}', '{{ $slot['label'] }}')"
                                class="p-3.5 rounded-xl border text-center transition-all hover:scale-105 active:scale-95 {{ $selectedSlot === $slot['start_time'] ? 'bg-gradient-to-r from-amber-500 to-rose-600 text-white font-bold border-transparent shadow-lg shadow-rose-500/20' : 'bg-white dark:bg-neutral-900 border-neutral-200 dark:border-neutral-800 text-neutral-800 dark:text-neutral-200 hover:border-amber-500' }}"
                            >
                                <span class="block text-sm font-bold">{{ $slot['formatted_start'] }}</span>
                                <span class="block text-[10px] opacity-75 font-medium mt-0.5">Ends at {{ $slot['formatted_end'] }}</span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- STEP 4: CUSTOMER DETAILS & PAYMENT REVIEW -->
    @if($currentStep === 4)
        <div class="max-w-4xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Customer Form & Payment -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-xs">
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Your Contact Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Full Name *</label>
                            <input
                                type="text"
                                wire:model="customerName"
                                placeholder="e.g. Jessica Miller"
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:outline-none"
                            >
                            @error('customerName') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Email Address *</label>
                                <input
                                    type="email"
                                    wire:model="customerEmail"
                                    placeholder="jessica@example.com"
                                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:outline-none"
                                >
                                @error('customerEmail') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Phone Number *</label>
                                <input
                                    type="tel"
                                    wire:model="customerPhone"
                                    placeholder="+1 (555) 000-0000"
                                    class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:outline-none"
                                >
                                @error('customerPhone') <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Special Requests or Notes (Optional)</label>
                            <textarea
                                wire:model="notes"
                                rows="3"
                                placeholder="Any allergies, styling preferences, or notes for the specialist..."
                                class="w-full px-4 py-2.5 rounded-xl border border-neutral-300 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 text-sm text-neutral-900 dark:text-white focus:ring-2 focus:ring-rose-500 focus:outline-none"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Selection -->
                <div class="bg-white dark:bg-neutral-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-xs">
                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Payment Method</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="p-4 rounded-xl border-2 cursor-pointer flex items-start gap-3 transition-all {{ $paymentMethod === 'pay_at_salon' ? 'border-rose-600 bg-rose-50/50 dark:bg-rose-950/20' : 'border-neutral-200 dark:border-neutral-800' }}">
                            <input type="radio" wire:model="paymentMethod" value="pay_at_salon" class="mt-1 text-rose-600 focus:ring-rose-500">
                            <div>
                                <span class="block font-bold text-sm text-neutral-900 dark:text-white">Pay at Salon</span>
                                <span class="block text-xs text-neutral-500 mt-0.5">Pay with Cash or Card upon arrival at the salon reception.</span>
                            </div>
                        </label>

                        <label class="p-4 rounded-xl border-2 cursor-pointer flex items-start gap-3 transition-all {{ $paymentMethod === 'online' ? 'border-rose-600 bg-rose-50/50 dark:bg-rose-950/20' : 'border-neutral-200 dark:border-neutral-800' }}">
                            <input type="radio" wire:model="paymentMethod" value="online" class="mt-1 text-rose-600 focus:ring-rose-500">
                            <div>
                                <span class="block font-bold text-sm text-neutral-900 dark:text-white">Online Card Pre-Pay</span>
                                <span class="block text-xs text-neutral-500 mt-0.5">Simulate instant credit card payment for seamless check-in.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right: Order Summary Sticky Card -->
            <div class="lg:col-span-1">
                <div class="sticky top-28 bg-white dark:bg-neutral-900 p-6 rounded-2xl border border-neutral-200 dark:border-neutral-800 shadow-lg space-y-5">
                    <h4 class="font-bold text-base text-neutral-900 dark:text-white border-b border-neutral-100 dark:border-neutral-800 pb-3">Booking Summary</h4>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Service:</span>
                            <span class="font-semibold text-neutral-800 dark:text-neutral-200 text-right">{{ $selectedService->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Duration:</span>
                            <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $selectedService->formatted_duration }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Specialist:</span>
                            <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $selectedStaffId === 'any' ? 'Any Specialist' : ($selectedStaffUser->name ?? 'Stylist') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Date:</span>
                            <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-neutral-500">Time:</span>
                            <span class="font-semibold text-neutral-800 dark:text-neutral-200">{{ $selectedSlotLabel }}</span>
                        </div>
                    </div>

                    <div class="border-t border-neutral-100 dark:border-neutral-800 pt-4 flex justify-between items-center">
                        <span class="font-bold text-neutral-900 dark:text-white">Total Amount</span>
                        <span class="text-2xl font-black text-rose-600 dark:text-rose-400">Rs. {{ number_format($selectedService->price, 2) }}</span>
                    </div>

                    <button
                        wire:click="confirmBooking"
                        wire:loading.attr="disabled"
                        class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-rose-600 text-white font-bold text-sm shadow-lg shadow-rose-500/25 hover:from-amber-600 hover:to-rose-700 hover:scale-[1.02] active:scale-[0.98] transition-all cursor-pointer disabled:opacity-50"
                    >
                        <span wire:loading.remove wire:target="confirmBooking">Confirm & Book Now</span>
                        <span wire:loading wire:target="confirmBooking">Processing Booking...</span>
                    </button>

                    <button wire:click="goToStep(3)" class="w-full py-2 text-center text-xs font-semibold text-neutral-500 hover:text-neutral-800 dark:hover:text-neutral-200">
                        &larr; Back to Time Slots
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- STEP 5: BOOKING CONFIRMATION SUCCESS -->
    @if($currentStep === 5 && $confirmedAppointment)
        <div class="max-w-2xl mx-auto bg-white dark:bg-neutral-900 p-8 rounded-3xl border border-neutral-200 dark:border-neutral-800 shadow-2xl text-center space-y-6 animate-scale-up">
            <div class="w-20 h-20 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 flex items-center justify-center mx-auto shadow-lg shadow-emerald-500/20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <div>
                <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300">Appointment Confirmed</span>
                <h2 class="text-3xl font-black text-neutral-900 dark:text-white mt-3">We look forward to seeing you!</h2>
                <p class="text-neutral-500 text-sm mt-1">A confirmation has been recorded. Here are your booking details:</p>
            </div>

            <!-- Booking Reference Code -->
            <div class="bg-neutral-50 dark:bg-neutral-800/60 p-4 rounded-2xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-between max-w-md mx-auto">
                <div class="text-left">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-neutral-400">Booking Reference</span>
                    <p class="text-xl font-black text-rose-600 dark:text-rose-400">{{ $confirmedAppointment->booking_reference }}</p>
                </div>
                <a href="{{ route('booking.lookup', ['ref' => $confirmedAppointment->booking_reference]) }}" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 hover:opacity-90">
                    Track Online
                </a>
            </div>

            <!-- Appointment Details Card -->
            <div class="bg-neutral-50 dark:bg-neutral-800/40 p-6 rounded-2xl text-left space-y-3 text-sm border border-neutral-100 dark:border-neutral-800">
                <div class="flex justify-between">
                    <span class="text-neutral-500">Service:</span>
                    <span class="font-bold text-neutral-900 dark:text-white">{{ $confirmedAppointment->service->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-neutral-500">Stylist:</span>
                    <span class="font-bold text-neutral-900 dark:text-white">{{ $confirmedAppointment->staff->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-neutral-500">Date & Time:</span>
                    <span class="font-bold text-neutral-900 dark:text-white">
                        {{ \Carbon\Carbon::parse($confirmedAppointment->appointment_date)->format('l, M j, Y') }} at {{ $confirmedAppointment->formatted_start_time }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-neutral-500">Customer:</span>
                    <span class="font-bold text-neutral-900 dark:text-white">{{ $confirmedAppointment->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-neutral-500">Total Price:</span>
                    <span class="font-black text-emerald-600 dark:text-emerald-400">Rs. {{ number_format($confirmedAppointment->total_price, 2) }}</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center pt-2">
                <button wire:click="resetBooking" class="px-6 py-3 rounded-xl bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 font-bold text-sm hover:opacity-90 transition">
                    Book Another Appointment
                </button>
                <a href="{{ route('home') }}" class="px-6 py-3 rounded-xl border border-neutral-200 dark:border-neutral-700 font-bold text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                    Return to Home
                </a>
            </div>
        </div>
    @endif

</div>
