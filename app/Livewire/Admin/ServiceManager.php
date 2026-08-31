<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ServiceManager extends Component
{
    public bool $showServiceModal = false;

    public ?int $editingServiceId = null;

    public string $name = '';

    public ?int $category_id = null;

    public string $description = '';

    public int $duration_minutes = 45;

    public int $buffer_time_minutes = 10;

    public float $price = 50.00;

    public ?string $image_url = '';

    public bool $is_featured = false;

    public bool $is_active = true;

    /**
     * @var array<int, int|string>
     */
    public array $selectedStaffIds = [];

    public ?string $feedbackMessage = null;

    public function openNewServiceModal(): void
    {
        $this->reset(['editingServiceId', 'name', 'description', 'image_url']);
        $this->duration_minutes = 45;
        $this->buffer_time_minutes = 10;
        $this->price = 50.00;
        $this->is_featured = false;
        $this->is_active = true;
        $this->category_id = Category::first()->id ?? null;
        $this->selectedStaffIds = User::where('role', 'staff')->pluck('id')->toArray();
        $this->showServiceModal = true;
    }

    public function editService(int $id): void
    {
        $service = Service::with('staff')->findOrFail($id);
        $this->editingServiceId = $service->id;
        $this->name = $service->name;
        $this->category_id = $service->category_id;
        $this->description = $service->description ?? '';
        $this->duration_minutes = $service->duration_minutes;
        $this->buffer_time_minutes = $service->buffer_time_minutes;
        $this->price = (float) $service->price;
        $this->image_url = $service->image_url ?? '';
        $this->is_featured = $service->is_featured;
        $this->is_active = $service->is_active;
        $this->selectedStaffIds = $service->staff->pluck('id')->toArray();

        $this->showServiceModal = true;
    }

    public function saveService(): void
    {
        $this->validate([
            'name' => 'required|string|min:3|max:150',
            'category_id' => 'required|exists:categories,id',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'buffer_time_minutes' => 'required|integer|min:0|max:120',
            'price' => 'required|numeric|min:0',
        ]);

        $slug = Str::slug($this->name);

        $service = Service::updateOrCreate(
            ['id' => $this->editingServiceId],
            [
                'name' => $this->name,
                'slug' => $slug,
                'category_id' => $this->category_id,
                'description' => $this->description,
                'duration_minutes' => $this->duration_minutes,
                'buffer_time_minutes' => $this->buffer_time_minutes,
                'price' => $this->price,
                'image_url' => $this->image_url,
                'is_featured' => $this->is_featured,
                'is_active' => $this->is_active,
            ]
        );

        $service->staff()->sync($this->selectedStaffIds);

        $this->showServiceModal = false;
        $this->feedbackMessage = 'Service saved successfully!';
    }

    public function toggleActive(int $id): void
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => ! $service->is_active]);
        $this->feedbackMessage = "Service {$service->name} status updated.";
    }

    public function render(): View
    {
        $categories = Category::with('services.staff')->orderBy('order')->get();
        $allStaff = User::where('role', 'staff')->get();

        return view('livewire.admin.service-manager', [
            'categories' => $categories,
            'allStaff' => $allStaff,
        ]);
    }
}
