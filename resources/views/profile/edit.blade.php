<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - ASyne</title>
  @vite('resources/css/app.css')
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  @vite('resources/css/login.css')
</head>
<body class="font-sans text-gray-800 bg-gray-50 scroll-smooth">

<img src="{{ asset('images/bg.png') }}" alt="Background" class="background-image opacity-20">
<img src="{{ asset('images/bg.png') }}" alt="Background" class="background-image flipped opacity-20">

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full backdrop-blur-xl bg-white/50 border-b border-gray-200 shadow-md z-50">
  <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-4">
    <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold text-indigo-600 tracking-tight">ASyne</a>
    <div class="flex items-center space-x-6 relative">

      <a href="{{ route('dashboard') }}" class="text-gray-700 font-medium hover:text-indigo-600 transition">Dashboard</a>

      <!-- Profile Dropdown -->
      <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 font-medium hover:text-indigo-600 transition focus:outline-none">
          <span>{{ Auth::user()->name }}</span>
          <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg z-50 overflow-hidden">
          <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-gray-700 dark:text-gray-100 hover:bg-indigo-50 dark:hover:bg-gray-800 transition">Profile</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-3 text-gray-700 dark:text-gray-100 hover:bg-red-50 dark:hover:bg-gray-800 transition">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Profile Page Content -->
<section class="min-h-screen flex flex-col items-center justify-start pt-28 pb-12 space-y-10">
  <h2 class="text-5xl font-extrabold text-center text-indigo-600 mb-6" data-aos="fade-down">Your Profile</h2>

  <div class="w-full max-w-5xl grid md:grid-cols-3 gap-10">

    <!-- Update Profile Information -->
    <div class="backdrop-blur-2xl bg-white/70 dark:bg-gray-800/70 shadow-xl rounded-3xl p-10 hover:scale-[1.02] transition-transform duration-300" data-aos="zoom-in">
      <h3 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Update Information</h3>

      <!-- Confirmation Message -->
      @if(session('profile-updated'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium text-center">
          {{ session('profile-updated') }}
        </div>
      @endif

      <div class="max-w-md mx-auto space-y-4">
        @include('profile.partials.update-profile-information-form')
      </div>
    </div>

    <!-- Update Password -->
    <div class="backdrop-blur-2xl bg-white/70 dark:bg-gray-800/70 shadow-xl rounded-3xl p-10 hover:scale-[1.02] transition-transform duration-300" data-aos="zoom-in" data-aos-delay="100">
      <h3 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Change Password</h3>

      <!-- Confirmation Message -->
      @if(session('password-updated'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium text-center">
          {{ session('password-updated') }}
        </div>
      @endif

      <div class="max-w-md mx-auto space-y-4">
        @include('profile.partials.update-password-form')
      </div>
    </div>

    <!-- Delete User -->
    <div class="backdrop-blur-2xl bg-red-50 dark:bg-red-900/50 shadow-xl rounded-3xl p-10 hover:scale-[1.02] transition-transform duration-300" data-aos="zoom-in" data-aos-delay="200">
      <h3 class="text-2xl font-bold mb-4 text-red-600 dark:text-red-400">Delete Account</h3>

      <!-- Confirmation Message -->
      @if(session('user-deleted'))
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm font-medium text-center">
          {{ session('user-deleted') }}
        </div>
      @endif

      <div class="max-w-md mx-auto space-y-4">
        @include('profile.partials.delete-user-form')
      </div>
    </div>

  </div>
</section>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
  AOS.init({ duration: 800, once: true });
</script>

</body>
</html>
