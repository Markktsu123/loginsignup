<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASyne</title>
  @vite('resources/css/app.css')
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  @vite('resources/css/login.css')
</head>
<body class="font-sans text-gray-800 bg-gray-50 scroll-smooth">

<img src="{{ asset('images/bg.png') }}" alt="Background" class="background-image opacity-20">
<img src="{{ asset('images/bg.png') }}" alt="Background" class="background-image flipped opacity-20">

<!-- Modern Navbar -->
<nav class="navbar">
  <div class="navbar-container">

    <!-- Logo -->
    <a href="#login" class="navbar-logo">Asyne</a>

    <!-- Links -->
    <div class="nav-links">
      <a href="#login">Home<span></span></a>
      <a href="#about">About<span></span></a>
      <a href="#faqs">FAQ’s<span></span></a>
      <a href="#contacts">Contacts<span></span></a>
    </div>
  </div>
</nav>

<!-- Modern Login Section -->
<section id="login" class="relative h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 via-blue-100 to-indigo-100 p-4 sm:p-6 overflow-hidden">
  
  <!-- Background Image Behind Form -->
  <img src="{{ asset('images/bg.png') }}" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-20 z-0">
  <img src="{{ asset('images/bg.png') }}" alt="Background Flipped" class="absolute inset-0 w-full h-full object-cover opacity-20 scale-x-[-1] scale-y-[-1] z-0">

  <!-- Login Form -->
  <div class="relative z-10 backdrop-blur-2xl bg-white/70 shadow-2xl rounded-3xl p-6 sm:p-8 lg:p-10 w-full max-w-md mx-auto border border-gray-200" data-aos="zoom-in">

    <!-- Title -->
    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-center text-indigo-600 mb-4 sm:mb-6 tracking-tight">Welcome Back</h2>
    <p class="text-center text-gray-700 mb-6 sm:mb-8 text-sm sm:text-base">Sign in to continue</p>

    <!-- Success Message -->
    @if (session('success'))
      <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span class="text-green-700 text-sm font-medium">{{ session('success') }}</span>
        </div>
      </div>
    @endif

    <!-- Password Changed Message -->
        @if (session('password-changed'))
          <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <div>
                <span class="text-green-700 text-sm font-medium">{{ session('password-changed') }}</span>
                <p class="text-green-600 text-xs mt-1">Please log in with your new password.</p>
              </div>
            </div>
          </div>
        @endif

    <!-- Error Message -->
    @if (session('error'))
      <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="text-red-700 text-sm font-medium">{{ session('error') }}</span>
        </div>
      </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
      @csrf
      <!-- Username -->
      <div class="relative">
        <input id="email" type="email" name="email" required autofocus tabindex="1"
          class="peer w-full px-4 py-3 rounded-xl border border-gray-300 text-gray-900 bg-white/80 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent transition-all duration-200 backdrop-blur-sm"
          placeholder="Username">
        <label for="email" class="absolute left-4 -top-2.5 text-sm text-gray-600 bg-white/90 px-1 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">Email</label>
      </div>

      <!-- Password -->
      <div class="relative">
        <input id="password" type="password" name="password" required tabindex="2"
          class="peer w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 text-gray-900 bg-white/80 focus:ring-2 focus:ring-indigo-500 focus:outline-none placeholder-transparent transition-all duration-200 backdrop-blur-sm"
          placeholder="Password">
        <label for="password" class="absolute left-4 -top-2.5 text-sm text-gray-600 bg-white/90 px-1 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-indigo-600">Password</label>
        <button type="button" onclick="togglePasswordVisibility('password', 'eyeIconLogin')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none p-1 rounded-md hover:bg-gray-100 transition-colors duration-200" tabindex="-1">
          <svg id="eyeIconLogin" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
        </button>
      </div>

      <!-- Remember & Forgot -->
      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center space-x-2">
          <input id="remember_me" type="checkbox" name="remember"
            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
          <span class="text-gray-700">Remember me</span>
        </label>
        <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline font-medium transition-colors duration-200">
          Forgot Password?
        </a>
      </div>

      <!-- Login Button -->
      <button type="submit" tabindex="3"
        class="w-full py-3 px-4 bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform">
        Log In
      </button>

    </form>

    <!-- Signup Button -->
    <div class="mt-6 sm:mt-8 text-center">
      <p class="text-gray-700 mb-3 text-sm sm:text-base">Don't have an account?</p>
      <a href="{{ route('register') }}"
        class="inline-block px-6 py-2 rounded-xl border border-indigo-500 text-indigo-600 font-semibold hover:bg-indigo-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transform hover:scale-105">
        Create Account
      </a>
    </div>

  </div>
</section>


<!-- About Section -->
<section id="about" class="min-h-screen px-6 py-28 flex flex-col items-center justify-center space-y-10 bg-white">
  <div class="max-w-6xl w-full" data-aos="fade-up">
    <div class="grid md:grid-cols-2 gap-10 items-center mb-16">
      <div>
        <h2 class="text-4xl md:text-5xl font-extrabold text-indigo-600 mb-4">
          Welcome to <span class="font-bold text-gray-900">ASyne,</span>
        </h2>
        <p class="text-xl md:text-2xl font-medium text-gray-900 leading-snug italic mb-6">
          ‘Bridging Silence, Building<br>Connection.’
        </p>
      </div>
      <div class="flex justify-center md:justify-end">
        <img src="/images/logo.png" alt="ASyne Logo" class="w-40 md:w-56">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white rounded-xl shadow-lg p-10 flex flex-col items-center justify-center hover:shadow-xl transition" data-aos="zoom-in">
        <img src="/images/11.png" alt="Feature 1" class="w-10 h-10 mb-4">
        <p class="text-gray-700 text-center text-sm">We want to break communication barriers between the deaf and hearing community by providing real-time sign-to-text and sign-to-speech translation.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-10 flex flex-col items-center justify-center hover:shadow-xl transition" data-aos="zoom-in" data-aos-delay="100">
        <img src="/images/22.png" alt="Feature 2" class="w-10 h-10 mb-4">
        <p class="text-gray-700 text-center text-sm">We want to empower deaf individuals to communicate independently in schools, workplaces, and daily life without always needing an interpreter.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-10 flex flex-col items-center justify-center hover:shadow-xl transition" data-aos="zoom-in" data-aos-delay="200">
        <img src="/images/33.png" alt="Feature 3" class="w-10 h-10 mb-4">
        <p class="text-gray-700 text-center text-sm">We want to promote inclusivity and awareness by encouraging both deaf and hearing people to learn and appreciate sign language.</p>
      </div>
    </div>
  </div>
</section>



<!-- FAQ Section -->
<section id="faqs" class="min-h-screen px-6 py-20">
  <h2 class="text-4xl font-bold mb-12 text-center text-indigo-600" data-aos="fade-down">Frequently Asked Questions</h2>
  <div class="max-w-4xl mx-auto grid gap-10">
    <div class="backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-6 flex items-start space-x-6 hover:scale-[1.02] transition-transform duration-300" data-aos="fade-left">
      <img src="/images/1.jpg" alt="Illustration" class="w-28 h-28 rounded-lg shadow">
      <div>
        <h3 class="font-semibold text-lg text-gray-900">Who can use this app?</h3>
        <p class="text-gray-700 text-sm mt-2">
          It’s designed for both sign language users and non-signers who want to communicate effectively.
        </p>
      </div>
    </div>
    <div class="backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-6 flex items-start space-x-6 hover:scale-[1.02] transition-transform duration-300" data-aos="fade-left" data-aos-delay="100">
      <img src="/images/2.jpg" alt="Illustration" class="w-28 h-28 rounded-lg shadow">
      <div>
        <h3 class="font-semibold text-lg text-gray-900">Does this app support all sign languages?</h3>
        <p class="text-gray-700 text-sm mt-2">
          Currently, it may support specific sign languages (e.g., ASL, FSL, BSL). Support for more languages will be added in future updates.
        </p>
      </div>
    </div>
    <div class="backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-6 flex items-start space-x-6 hover:scale-[1.02] transition-transform duration-300" data-aos="fade-left" data-aos-delay="200">
      <img src="/images/3.jpg" alt="Illustration" class="w-28 h-28 rounded-lg shadow">
      <div>
        <h3 class="font-semibold text-lg text-gray-900">Can I use this app to learn sign language?</h3>
        <p class="text-gray-700 text-sm mt-2">
          While the app helps recognize and translate signs, it is not a replacement for formal sign language learning. It can, however, assist in practicing.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Contacts Section -->
<footer id="contacts" class="bg-gray-900 text-gray-300 py-10">
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">
    <div>
      <h3 class="text-2xl font-bold text-white">ASyne</h3>
      <p class="mt-2 text-sm">Bridging communication, making the world inclusive.</p>
    </div>

    <div>
      <h4 class="text-lg font-semibold text-white mb-3">Contact Us</h4>
      <p class="flex items-center space-x-2"><span>📧</span><span>support@asyne.com</span></p>
      <p class="flex items-center space-x-2"><span>📞</span><span>+63 912 345 6789</span></p>
      <p class="flex items-center space-x-2"><span>🏢</span><span>Manila, Philippines</span></p>
    </div>

    <div>
      <h4 class="text-lg font-semibold text-white mb-3">Follow Us</h4>
      <div class="flex space-x-4">
        <a href="#" class="hover:text-blue-400">🌐</a>
        <a href="#" class="hover:text-blue-400">🐦</a>
        <a href="#" class="hover:text-blue-400">📘</a>
      </div>
    </div>
  </div>

  <div class="text-center text-sm text-gray-500 mt-8">
    © 2025 ASyne. All rights reserved.
  </div>
</footer>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
  AOS.init({ duration: 800, once: true });

  function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
      input.type = 'text';
      icon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
      `;
    } else {
      input.type = 'password';
      icon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      `;
    }
  }
</script>

</body>
</html>
