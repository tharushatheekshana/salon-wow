<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    @include('partials.head')
    <title>{{ $title ?? 'Salon WOW - Unisex Hair & Beauty Salon | Pambahinna, Belihuloya' }}</title>
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900 dark:bg-neutral-950 dark:text-neutral-100 antialiased font-sans flex flex-col">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 w-full backdrop-blur-md bg-white/85 dark:bg-neutral-900/85 border-b border-neutral-200/80 dark:border-neutral-800/80 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="/images/salon-wow-logo.jpg" alt="Salon WOW Logo" class="w-12 h-12 rounded-xl object-cover shadow-md shadow-rose-500/20 group-hover:scale-105 transition-transform border-2 border-amber-500/40">
                <div>
                    <span class="font-bold text-xl tracking-tight text-neutral-900 dark:text-white flex items-center gap-1.5">
                        SALON <span class="bg-gradient-to-r from-amber-600 to-rose-600 bg-clip-text text-transparent">WOW</span>
                    </span>
                    <span class="text-[10px] tracking-widest uppercase font-semibold text-neutral-400 block -mt-1">Pambahinna &bull; Belihuloya</span>
                </div>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('home') }}" class="text-neutral-600 hover:text-amber-600 dark:text-neutral-300 dark:hover:text-amber-400 transition-colors">Home</a>
                <a href="{{ route('home') }}#services" class="text-neutral-600 hover:text-amber-600 dark:text-neutral-300 dark:hover:text-amber-400 transition-colors">Services</a>
                <a href="{{ route('home') }}#stylists" class="text-neutral-600 hover:text-amber-600 dark:text-neutral-300 dark:hover:text-amber-400 transition-colors">Specialists</a>
                <a href="{{ route('home') }}#reviews" class="text-neutral-600 hover:text-amber-600 dark:text-neutral-300 dark:hover:text-amber-400 transition-colors">Reviews</a>
                <a href="{{ route('booking.lookup') }}" class="text-neutral-600 hover:text-amber-600 dark:text-neutral-300 dark:hover:text-amber-400 transition-colors">Track Booking</a>
            </nav>

            <!-- Actions & Auth -->
            <div class="flex items-center gap-3">
                <a href="tel:0711544071" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-neutral-700 dark:text-neutral-300 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    071 154 4071
                </a>

                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl text-neutral-800 dark:text-neutral-200 bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 transition">
                            Admin Portal
                        </a>
                    @else
                        <a href="{{ route('customer.appointments') }}" class="px-3.5 py-2 text-xs font-bold rounded-xl text-neutral-800 dark:text-neutral-200 bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 transition">
                            My Bookings
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 text-xs font-semibold rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium rounded-lg text-neutral-700 dark:text-neutral-200 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition">
                        Sign In
                    </a>
                @endauth

                <a href="{{ route('book') }}" class="relative inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all bg-gradient-to-r from-amber-500 to-rose-600 rounded-xl shadow-md shadow-rose-500/20 hover:from-amber-600 hover:to-rose-700 hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]">
                    Book Appointment
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-neutral-900 text-neutral-400 py-12 border-t border-neutral-800 text-sm mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <img src="/images/salon-wow-logo.jpg" alt="Salon WOW Logo" class="w-10 h-10 rounded-xl object-cover border border-amber-500/30">
                    <span class="font-bold text-lg text-white">SALON WOW</span>
                </div>
                <p class="text-xs text-neutral-400 leading-relaxed">
                    Unisex Hair, Beauty, Grooming & Bridal Salon serving Pambahinna, Belihuloya, Sabaragamuwa University community, and Balangoda.
                </p>
                <div class="pt-1">
                    <a href="https://www.facebook.com/people/Salon-WOW/61557814366655/" target="_blank" class="inline-flex items-center gap-2 text-xs font-semibold text-blue-400 hover:underline">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Follow us on Facebook
                    </a>
                </div>
                <p class="text-xs text-neutral-500">
                    &copy; {{ date('Y') }} Salon WOW. All rights reserved.
                </p>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">Opening Hours</h4>
                <ul class="space-y-2 text-xs">
                    <li class="flex justify-between"><span>Monday – Sunday:</span> <span class="text-emerald-400 font-semibold">8:30 AM – 7:30 PM</span></li>
                    <li class="text-neutral-400 text-[11px] mt-1">Open 7 days a week for university students & public</li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">Salon Location</h4>
                <p class="text-xs text-neutral-300 leading-relaxed">
                    Pambahinna Junction,<br>
                    Belihuloya, Balangoda,<br>
                    Sri Lanka (Near SUSL)
                </p>
                <p class="text-xs text-neutral-300 mt-2">
                    Tel: <strong>071 154 4071</strong> / <strong>071 160 5714</strong><br>
                    Email: salonwow.pambahinna@gmail.com
                </p>
            </div>

            <div>
                <h4 class="font-semibold text-white mb-4">Quick Links</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('book') }}" class="hover:text-white transition">Book an Appointment</a></li>
                    <li><a href="{{ route('booking.lookup') }}" class="hover:text-white transition">Check Appointment Status</a></li>
                    <li><a href="https://www.facebook.com/people/Salon-WOW/61557814366655/" target="_blank" class="hover:text-white transition">Salon WOW on Facebook</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white transition">Staff & Client Portal</a></li>
                </ul>
            </div>
        </div>
    </footer>

    @fluxScripts
</body>
</html>
