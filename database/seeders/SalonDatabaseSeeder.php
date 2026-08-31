<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Category;
use App\Models\Review;
use App\Models\Service;
use App\Models\StaffProfile;
use App\Models\StaffSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SalonDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@salonwow.lk'],
            [
                'name' => 'Salon WOW Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '071 154 4071',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&auto=format&fit=crop&q=80',
            ]
        );

        // 2. Demo Customer
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Kavindu Perera',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '077 342 9182',
                'avatar' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=150&auto=format&fit=crop&q=80',
            ]
        );

        // 3. Exactly Two Specialists of Salon WOW
        $staffMembers = [
            [
                'name' => 'Nuwan Pradeep',
                'email' => 'nuwan@salonwow.lk',
                'role' => 'staff',
                'phone' => '071 154 4071',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&auto=format&fit=crop&q=80',
                'title' => 'Senior Hair Stylist & Barber',
                'bio' => 'Specialist in modern gents haircuts, beard design, precision fading, head massage, and groom styling.',
                'rating' => 4.95,
            ],
            [
                'name' => 'Sanduni Fernando',
                'email' => 'sanduni@salonwow.lk',
                'role' => 'staff',
                'phone' => '071 160 5714',
                'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=150&auto=format&fit=crop&q=80',
                'title' => 'Bridal Dressing & Ladies Hair Specialist',
                'bio' => 'Experienced in Kandyan & Western bridal dressing, saree draping, hair rebonding, coloring, and herbal facials.',
                'rating' => 4.98,
            ],
        ];

        // Clean up any other staff users if they exist
        $existingStaffEmails = array_column($staffMembers, 'email');
        User::where('role', 'staff')->whereNotIn('email', $existingStaffEmails)->delete();

        $createdStaff = [];
        foreach ($staffMembers as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => $data['role'],
                    'phone' => $data['phone'],
                    'avatar' => $data['avatar'],
                ]
            );

            StaffProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'title' => $data['title'],
                    'bio' => $data['bio'],
                    'rating' => $data['rating'],
                    'is_active' => true,
                ]
            );

            // Create weekly schedules (Mon-Sun 8:30am - 7:30pm, Lunch 1:00pm - 2:00pm)
            for ($day = 0; $day <= 6; $day++) {
                StaffSchedule::updateOrCreate(
                    ['user_id' => $user->id, 'day_of_week' => $day],
                    [
                        'start_time' => '08:30:00',
                        'end_time' => '19:30:00',
                        'break_start_time' => '13:00:00',
                        'break_end_time' => '14:00:00',
                        'is_day_off' => false, // Open 7 days
                    ]
                );
            }

            $createdStaff[$data['name']] = $user;
        }

        // 4. Categories & Real Services of Salon WOW
        $categoriesData = [
            [
                'name' => 'Gents Hair & Grooming',
                'slug' => 'gents-hair-grooming',
                'icon' => 'scissors',
                'description' => 'Professional haircutting, precision fade styling, beard sculpting, and hair washing.',
                'order' => 1,
                'services' => [
                    [
                        'name' => 'Executive Gents Cut & Beard Trim',
                        'slug' => 'executive-gents-cut-beard-trim',
                        'description' => 'Customized haircut, side fade or classic cut, hot towel beard trim, razor edge-up, and wash.',
                        'duration_minutes' => 45,
                        'buffer_time_minutes' => 10,
                        'price' => 1200.00,
                        'image_url' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => true,
                        'staff' => ['Nuwan Pradeep'],
                    ],
                    [
                        'name' => 'Modern Fade Haircut & Styling',
                        'slug' => 'modern-fade-haircut-styling',
                        'description' => 'Skin fade, taper fade or crop top cut with matte styling clay finish.',
                        'duration_minutes' => 30,
                        'buffer_time_minutes' => 10,
                        'price' => 800.00,
                        'image_url' => 'https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => true,
                        'staff' => ['Nuwan Pradeep'],
                    ],
                    [
                        'name' => 'Gents Head Massage & Scalp Therapy',
                        'slug' => 'gents-head-massage-scalp-therapy',
                        'description' => 'Relaxing herbal oil head massage to relieve tension and nourish hair roots.',
                        'duration_minutes' => 30,
                        'buffer_time_minutes' => 10,
                        'price' => 1500.00,
                        'image_url' => 'https://images.unsplash.com/photo-1519415510236-718bdfcd89c8?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => false,
                        'staff' => ['Nuwan Pradeep'],
                    ],
                ],
            ],
            [
                'name' => 'Ladies Hair Styling & Treatments',
                'slug' => 'ladies-hair-styling-treatments',
                'icon' => 'sparkles',
                'description' => 'Precision haircuts, rebonding, keratin smoothing, tinting, and hair spa.',
                'order' => 2,
                'services' => [
                    [
                        'name' => 'Ladies Haircut, Layering & Blow-Dry',
                        'slug' => 'ladies-haircut-layering-blow-dry',
                        'description' => 'Personalized style consultation, professional layered cut, hair wash, and silky blowout.',
                        'duration_minutes' => 60,
                        'buffer_time_minutes' => 10,
                        'price' => 2200.00,
                        'image_url' => 'https://images.unsplash.com/photo-1560869713-7d0a29430803?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => true,
                        'staff' => ['Sanduni Fernando'],
                    ],
                    [
                        'name' => 'Permanent Hair Rebonding / Smoothing',
                        'slug' => 'permanent-hair-rebonding-smoothing',
                        'description' => 'Glossy, poker-straight hair rebonding using premium conditioning creams.',
                        'duration_minutes' => 180,
                        'buffer_time_minutes' => 20,
                        'price' => 12500.00,
                        'image_url' => 'https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => true,
                        'staff' => ['Sanduni Fernando'],
                    ],
                    [
                        'name' => 'Hair Color Highlights & Toner',
                        'slug' => 'hair-color-highlights-toner',
                        'description' => 'Foil highlights, balayage streaks, or full root retouch with shine treatment.',
                        'duration_minutes' => 120,
                        'buffer_time_minutes' => 15,
                        'price' => 6500.00,
                        'image_url' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => false,
                        'staff' => ['Sanduni Fernando'],
                    ],
                ],
            ],
            [
                'name' => 'Bridal & Event Dressing',
                'slug' => 'bridal-event-dressing',
                'icon' => 'gem',
                'description' => 'Kandyan & Western bridal dressing, bridal makeup, saree draping, and groom dressing.',
                'order' => 3,
                'services' => [
                    [
                        'name' => 'Bridal Dressing & Makeup Package',
                        'slug' => 'bridal-dressing-makeup-package',
                        'description' => 'Complete bride styling (Kandyan/Western/Indian), HD makeup, hair design, jewelry setting, and saree draping.',
                        'duration_minutes' => 180,
                        'buffer_time_minutes' => 30,
                        'price' => 35000.00,
                        'image_url' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => true,
                        'staff' => ['Sanduni Fernando'],
                    ],
                    [
                        'name' => 'Party Makeup & Saree Draping',
                        'slug' => 'party-makeup-saree-draping',
                        'description' => 'Long-lasting party makeup, eye makeup, elegant hair do, and professional saree pleating.',
                        'duration_minutes' => 75,
                        'buffer_time_minutes' => 15,
                        'price' => 4500.00,
                        'image_url' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => true,
                        'staff' => ['Sanduni Fernando'],
                    ],
                    [
                        'name' => 'Groom Dressing & Styling',
                        'slug' => 'groom-dressing-styling',
                        'description' => 'Complete wedding day grooming, haircut, facial glow touch-up, and Nilame / Western suit setting.',
                        'duration_minutes' => 60,
                        'buffer_time_minutes' => 15,
                        'price' => 8000.00,
                        'image_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => false,
                        'staff' => ['Nuwan Pradeep'],
                    ],
                ],
            ],
            [
                'name' => 'Facials & Skin Care',
                'slug' => 'facials-skin-care',
                'icon' => 'sun',
                'description' => 'Herbal facials, gold facials, acne treatment, clean-ups, and face threading.',
                'order' => 4,
                'services' => [
                    [
                        'name' => 'Gold Glow Herbal Facial',
                        'slug' => 'gold-glow-herbal-facial',
                        'description' => 'Deep cleansing, gentle scrub, steam extraction, herbal gold massage, and brightening face pack.',
                        'duration_minutes' => 60,
                        'buffer_time_minutes' => 10,
                        'price' => 4500.00,
                        'image_url' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => true,
                        'staff' => ['Sanduni Fernando'],
                    ],
                    [
                        'name' => 'Deep Pore Face Clean-up & Steam',
                        'slug' => 'deep-pore-face-cleanup-steam',
                        'description' => 'Instant freshening treatment removing blackheads, oil, and dead skin cells.',
                        'duration_minutes' => 45,
                        'buffer_time_minutes' => 10,
                        'price' => 2800.00,
                        'image_url' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?w=600&auto=format&fit=crop&q=80',
                        'is_featured' => false,
                        'staff' => ['Nuwan Pradeep', 'Sanduni Fernando'],
                    ],
                ],
            ],
        ];

        $allCreatedServices = [];

        foreach ($categoriesData as $catData) {
            $category = Category::updateOrCreate(
                ['slug' => $catData['slug']],
                [
                    'name' => $catData['name'],
                    'icon' => $catData['icon'],
                    'description' => $catData['description'],
                    'order' => $catData['order'],
                    'is_active' => true,
                ]
            );

            foreach ($catData['services'] as $svcData) {
                $service = Service::updateOrCreate(
                    ['slug' => $svcData['slug']],
                    [
                        'category_id' => $category->id,
                        'name' => $svcData['name'],
                        'description' => $svcData['description'],
                        'duration_minutes' => $svcData['duration_minutes'],
                        'buffer_time_minutes' => $svcData['buffer_time_minutes'],
                        'price' => $svcData['price'],
                        'image_url' => $svcData['image_url'],
                        'is_featured' => $svcData['is_featured'],
                        'is_active' => true,
                    ]
                );

                // Attach staff
                $staffIds = [];
                foreach ($svcData['staff'] as $staffName) {
                    if (isset($createdStaff[$staffName])) {
                        $staffIds[] = $createdStaff[$staffName]->id;
                    }
                }
                $service->staff()->sync($staffIds);

                $allCreatedServices[] = $service;
            }
        }

        // 5. Sample Past & Upcoming Appointments with Authentic Reviews
        $serviceCut = Service::where('slug', 'executive-gents-cut-beard-trim')->first();
        $serviceFade = Service::where('slug', 'modern-fade-haircut-styling')->first();
        $serviceRebond = Service::where('slug', 'permanent-hair-rebonding-smoothing')->first();
        // 5. Official Facebook Reviews provided by Salon WOW page
        Review::query()->delete();

        $serviceCut = Service::where('slug', 'executive-gents-cut-beard-trim')->first();
        $serviceFade = Service::where('slug', 'modern-fade-haircut-styling')->first();

        $nuwan = $createdStaff['Nuwan Pradeep'] ?? null;

        $reviewsData = [
            [
                'ref' => 'SLN-FB-VIRAJ',
                'name' => 'Viraj Ekanayake',
                'email' => 'viraj.ekanayake@facebook.com',
                'phone' => '071 554 1290',
                'service' => $serviceFade ?? $serviceCut,
                'staff' => $nuwan,
                'rating' => 5,
                'comment' => 'Just had a fantastic experience here! The service was professional, and the environment was clean and modern. I’ll definitely be back for my next haircut. Highly recommend! ✂️✨',
                'date' => '2024-05-17',
            ],
            [
                'ref' => 'SLN-FB-VIMUKTHI',
                'name' => 'Vimukthi Vithanage',
                'email' => 'vimukthi.v@facebook.com',
                'phone' => '077 882 3411',
                'service' => $serviceCut,
                'staff' => $nuwan,
                'rating' => 5,
                'comment' => 'I recently took my son to Salon WOW for his haircut and decided to get mine done as well. The experience was fantastic from start to finish! We will definitely be returning for our next haircuts. Highly recommended!',
                'date' => '2024-06-16',
            ],
            [
                'ref' => 'SLN-FB-SHARADA',
                'name' => 'Sharada Dilshan',
                'email' => 'sharada.dilshan@facebook.com',
                'phone' => '078 991 7654',
                'service' => $serviceCut,
                'staff' => $nuwan,
                'rating' => 5,
                'comment' => 'Very good customer service and that is the great place to all agers. Fantastic haircuts.',
                'date' => '2024-04-18',
            ],
        ];

        foreach ($reviewsData as $rev) {
            if ($rev['service'] && $rev['staff']) {
                $apt = Appointment::updateOrCreate(
                    ['booking_reference' => $rev['ref']],
                    [
                        'customer_id' => null,
                        'customer_name' => $rev['name'],
                        'customer_email' => $rev['email'],
                        'customer_phone' => $rev['phone'],
                        'service_id' => $rev['service']->id,
                        'staff_id' => $rev['staff']->id,
                        'appointment_date' => $rev['date'],
                        'start_time' => '10:00:00',
                        'end_time' => '10:45:00',
                        'duration_minutes' => $rev['service']->duration_minutes,
                        'service_price' => $rev['service']->price,
                        'total_price' => $rev['service']->price,
                        'status' => 'completed',
                        'payment_status' => 'paid',
                        'payment_method' => 'cash',
                    ]
                );

                Review::updateOrCreate(
                    ['appointment_id' => $apt->id],
                    [
                        'customer_id' => null,
                        'service_id' => $rev['service']->id,
                        'staff_id' => $rev['staff']->id,
                        'rating' => $rev['rating'],
                        'comment' => $rev['comment'],
                        'is_published' => true,
                    ]
                );
            }
        }

        // Future appointment for Demo customer
        if ($serviceCut && $nuwan) {
            Appointment::updateOrCreate(
                ['booking_reference' => 'SLN-773192'],
                [
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'customer_phone' => $customer->phone,
                    'service_id' => $serviceCut->id,
                    'staff_id' => $nuwan->id,
                    'appointment_date' => Carbon::tomorrow()->toDateString(),
                    'start_time' => '14:00:00',
                    'end_time' => '14:45:00',
                    'duration_minutes' => 45,
                    'service_price' => 1200.00,
                    'total_price' => 1200.00,
                    'status' => 'confirmed',
                    'payment_status' => 'pay_at_salon',
                    'payment_method' => 'pay_at_salon',
                    'notes' => 'Campus event styling.',
                ]
            );
        }
    }
}
