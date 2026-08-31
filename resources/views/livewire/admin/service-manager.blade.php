<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-neutral-900 dark:text-white">Services & Treatments Catalog</h1>
            <p class="text-xs text-neutral-500 mt-1">Configure salon treatments, pricing, durations, buffer times, and assigned specialists.</p>
        </div>
        <button
            wire:click="openNewServiceModal"
            class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-rose-600 text-white font-bold text-xs shadow-md hover:from-amber-600 hover:to-rose-700 transition cursor-pointer"
        >
            + Add New Service
        </button>
    </div>

    @if($feedbackMessage)
        <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-xs font-semibold">
            {{ $feedbackMessage }}
        </div>
    @endif

    <div class="space-y-8">
        @foreach($categories as $category)
            <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden shadow-xs">
                <div class="p-4 bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-sm text-neutral-900 dark:text-white">{{ $category->name }}</h3>
                        <p class="text-[11px] text-neutral-500">{{ $category->description }}</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-zinc-200 dark:bg-zinc-700 text-neutral-700 dark:text-neutral-300">
                        {{ $category->services->count() }} Services
                    </span>
                </div>

                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($category->services as $service)
                        <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/30 transition">
                            <div class="flex items-start gap-4">
                                @if($service->image_url)
                                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-12 h-12 rounded-xl object-cover">
                                @endif
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-sm text-neutral-900 dark:text-white">{{ $service->name }}</h4>
                                        @if($service->is_featured)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">Featured</span>
                                        @endif
                                        @if(! $service->is_active)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-neutral-200 text-neutral-600 dark:bg-neutral-800 dark:text-neutral-400">Disabled</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-neutral-500 mt-0.5">{{ $service->description }}</p>
                                    <div class="flex items-center gap-3 text-[11px] text-neutral-400 mt-2">
                                        <span>⏱ {{ $service->formatted_duration }} (+{{ $service->buffer_time_minutes }}m buffer)</span>
                                        <span>&bull;</span>
                                        <span>👥 {{ $service->staff->count() }} Specialists assigned</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 justify-between sm:justify-end">
                                <span class="text-lg font-bold text-neutral-900 dark:text-white">Rs. {{ number_format($service->price, 2) }}</span>
                                <div class="flex items-center gap-2">
                                    <button
                                        wire:click="toggleActive({{ $service->id }})"
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $service->is_active ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-neutral-100 text-neutral-600' }}"
                                    >
                                        {{ $service->is_active ? 'Active' : 'Hidden' }}
                                    </button>
                                    <button
                                        wire:click="editService({{ $service->id }})"
                                        class="px-3 py-1 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-xs font-semibold text-neutral-700 dark:text-neutral-300 hover:bg-zinc-200"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-neutral-500">
                            No services added in this category yet.
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>

    <!-- Service Create/Edit Modal -->
    @if($showServiceModal)
        <div class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-3xl max-w-lg w-full p-6 space-y-4 shadow-2xl border border-zinc-200 dark:border-zinc-800 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center border-b border-zinc-100 dark:border-zinc-800 pb-3">
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white">
                        {{ $editingServiceId ? 'Edit Service' : 'Add New Service' }}
                    </h3>
                    <button wire:click="$set('showServiceModal', false)" class="text-neutral-400 hover:text-neutral-600">&times;</button>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <label class="block font-semibold mb-1">Service Name *</label>
                        <input type="text" wire:model="name" placeholder="e.g. Balayage & Blowout" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        @error('name') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Category *</label>
                        <select wire:model="category_id" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Description</label>
                        <textarea wire:model="description" rows="2" placeholder="Brief overview of the treatment..." class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800"></textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block font-semibold mb-1">Duration (min) *</label>
                            <input type="number" wire:model="duration_minutes" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Buffer (min)</label>
                            <input type="number" wire:model="buffer_time_minutes" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Price (Rs.) *</label>
                            <input type="number" step="0.5" wire:model="price" class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                        </div>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Image URL</label>
                        <input type="url" wire:model="image_url" placeholder="https://..." class="w-full px-3 py-2 rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Assign Stylists</label>
                        <div class="grid grid-cols-2 gap-2 max-h-32 overflow-y-auto p-2 border border-zinc-200 dark:border-zinc-700 rounded-xl">
                            @foreach($allStaff as $st)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" wire:model="selectedStaffIds" value="{{ $st->id }}" class="rounded text-rose-600 focus:ring-rose-500">
                                    <span>{{ $st->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center gap-6 pt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_featured" class="rounded text-rose-600 focus:ring-rose-500">
                            <span class="font-semibold">Featured on Landing</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="rounded text-rose-600 focus:ring-rose-500">
                            <span class="font-semibold">Active & Bookable</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                    <button wire:click="$set('showServiceModal', false)" class="px-4 py-2 text-xs font-bold text-neutral-500">Cancel</button>
                    <button wire:click="saveService" class="px-5 py-2 text-xs font-bold text-white bg-gradient-to-r from-amber-500 to-rose-600 rounded-xl shadow-md">Save Service</button>
                </div>
            </div>
        </div>
    @endif
</div>
