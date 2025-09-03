<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASyne</title>
  @vite('resources/css/app.css')

  <!-- AOS Animation CSS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>
<body class="font-sans text-gray-800 bg-white scroll-smooth">

<img src="{{ asset('images/bg.png') }}" alt="Background" class="background-image">

  <!-- Modern Navbar -->
<nav class="fixed top-0 left-0 w-full backdrop-blur-lg bg-white/60 border-b border-white/30 shadow-md z-50">
  <div class="max-w-6xl mx-auto px-6 flex justify-between items-center py-4">

    <!-- Logo -->
    <a href="#login" class="text-2xl font-extrabold text-black-600 tracking-wide">Asyne</a>

    <!-- Links -->
    <div class="flex space-x-8">
      <a href="#login" class="relative text-gray-700 font-medium hover:text-indigo-600 transition group">
        Home
        <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-indigo-600 transition-all group-hover:w-full"></span>
      </a>
      <a href="#about" class="relative text-gray-700 font-medium hover:text-indigo-600 transition group">
        About
        <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-indigo-600 transition-all group-hover:w-full"></span>
      </a>
      <a href="#faqs" class="relative text-gray-700 font-medium hover:text-indigo-600 transition group">
        FAQ’s
        <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-indigo-600 transition-all group-hover:w-full"></span>
      </a>
      <a href="#contacts" class="relative text-gray-700 font-medium hover:text-indigo-600 transition group">
        Contacts
        <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-indigo-600 transition-all group-hover:w-full"></span>
      </a>
    </div>
  </div>
</nav>

<!-- Modern Login Section -->
<section id="login" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 via-dark blue=-200 to-light blue-200">
  <div class="backdrop-blur-lg bg-white/70 shadow-2xl rounded-3xl p-10 w-full max-w-md border border-gray-100" data-aos="zoom-in">

    <!-- Title -->
    <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-6 tracking-tight">Welcome Back</h2>
    <p class="text-center text-gray-600 mb-8">Sign in to continue</p>

    <!-- Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
      @csrf

      <!-- Username -->
      <div class="relative">
        <input id="email" type="email" name="email" required autofocus
          class="peer w-full px-4 py-3 rounded-xl border border-gray-300 text-gray-900 bg-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-transparent"
          placeholder="Username">
        <label for="email" class="absolute left-4 -top-2.5 text-sm text-gray-600 bg-white/70 px-1 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">Username</label>
      </div>

      <!-- Password -->
      <div class="relative">
        <input id="password" type="password" name="password" required
          class="peer w-full px-4 py-3 rounded-xl border border-gray-300 text-gray-900 bg-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none placeholder-transparent"
          placeholder="Password">
        <label for="password" class="absolute left-4 -top-2.5 text-sm text-gray-600 bg-white/70 px-1 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">Password</label>
      </div>

      <!-- Remember & Forgot -->
      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center space-x-2">
          <input id="remember_me" type="checkbox" name="remember"
            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
          <span class="text-gray-700">Remember me</span>
        </label>
        <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline font-medium">
          Forgot Password?
        </a>
      </div>

      <!-- Login Button -->
      <button type="submit"
        class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-semibold rounded-xl shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-200">
        Sign In
      </button>
    </form>

    <!-- Signup Button -->
    <div class="mt-8 text-center">
      <p class="text-gray-700 mb-3">Don’t have an account?</p>
      <a href="{{ route('register') }}"
        class="inline-block px-6 py-2 rounded-xl border border-blue-500 text-blue-600 font-semibold hover:bg-blue-50 transition">
        Create Account
      </a>
    </div>
  </div>
</section>



  <!-- About Section -->
<section id="about" class="min-h-screen bg-blue-100 px-6 py-20 flex flex-col items-center justify-center">
  <div class="max-w-6xl w-full" data-aos="fade-up">
    <!-- Top Part: Logo + Tagline -->
    <div class="grid md:grid-cols-2 gap-10 items-center mb-16">
      <!-- Left: Text -->
      <div>
        <h2 class="text-xl md:text-2xl text-gray-800 mb-4">
          Welcome to <span class="font-bold text-gray-900">ASyne,</span>
        </h2>
        <p class="text-2xl md:text-3xl font-medium text-gray-900 leading-snug italic">
          ‘Bridging Silence, Building<br>Connection.’
        </p>
      </div>
      <!-- Right: Logo -->
      <div class="flex justify-center md:justify-end">
        <img src="/images/logo.png" alt="ASyne Logo" class="w-40 md:w-56">
      </div>
    </div>

    <!-- Bottom Part: Feature Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white rounded-xl shadow-lg p-10 flex flex-col items-center justify-center hover:shadow-xl transition">
        <img src="/images/11.png" alt="Feature 1" class="w-10 h-10 mb-4">
        <p class="text-gray-700 text-center text-sm">We want to break communication barriers between the deaf and hearing community by providing real-time sign-to-text and sign-to-speech translation.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-10 flex flex-col items-center justify-center hover:shadow-xl transition">
        <img src="/images/22.png" alt="Feature 2" class="w-10 h-10 mb-4">
        <p class="text-gray-700 text-center text-sm">We want to empower deaf individuals to communicate independently in schools, workplaces, and daily life without always needing an interpreter.</p>
      </div>
      <div class="bg-white rounded-xl shadow-lg p-10 flex flex-col items-center justify-center hover:shadow-xl transition">
        <img src="/images/33.png" alt="Feature 3" class="w-10 h-10 mb-4">
        <p class="text-gray-700 text-center text-sm">We want to promote inclusivity and awareness by encouraging both deaf and hearing people to learn and appreciate sign language.</p>
      </div>
    </div>
  </div>
</section>


  <!-- FAQ’s Section -->
  <section id="faqs" class="min-h-screen px-6 py-20 bg-white">
    <h2 class="text-3xl font-bold mb-12 text-center text-gray-900" data-aos="fade-down">Frequently Asked Questions</h2>
    <div class="max-w-4xl mx-auto space-y-10">

      <div class="flex items-start space-x-6" data-aos="fade-left">
        <img src="/images/1.jpg" alt="Illustration" class="w-28 h-28 rounded-lg shadow">
        <div>
          <h3 class="font-semibold text-lg">Who can use this app?</h3>
          <p class="text-gray-700 text-sm mt-2">
            It’s designed for both sign language users and non-signers who want to communicate effectively.
          </p>
        </div>
      </div>

      <div class="flex items-start space-x-6" data-aos="fade-left" data-aos-delay="200">
        <img src="/images/2.jpg" alt="Illustration" class="w-28 h-28 rounded-lg shadow">
        <div>
          <h3 class="font-semibold text-lg">Does this app support all sign languages?</h3>
          <p class="text-gray-700 text-sm mt-2">
            Currently, it may support specific sign languages (e.g., ASL, FSL, BSL).
            Support for more languages will be added in future updates.
          </p>
        </div>
      </div>

      <div class="flex items-start space-x-6" data-aos="fade-left" data-aos-delay="400">
        <img src="/images/3.jpg" alt="Illustration" class="w-28 h-28 rounded-lg shadow">
        <div>
          <h3 class="font-semibold text-lg">Can I use this app to learn sign language?</h3>
          <p class="text-gray-700 text-sm mt-2">
            While the app helps recognize and translate signs, it is not a replacement for formal
            sign language learning. It can, however, assist in practicing.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contacts Section (Footer Style) -->
  <footer id="contacts" class="bg-gray-900 text-gray-300 py-10">
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-8">
      <!-- Logo + Tagline -->
      <div>
        <h3 class="text-2xl font-bold text-white">ASyne</h3>
        <p class="mt-2 text-sm">Bridging communication, making the world inclusive.</p>
      </div>

      <!-- Contact Info -->
      <div>
        <h4 class="text-lg font-semibold text-white mb-3">Contact Us</h4>
        <p class="flex items-center space-x-2"><span>📧</span><span>support@asyne.com</span></p>
        <p class="flex items-center space-x-2"><span>📞</span><span>+63 912 345 6789</span></p>
        <p class="flex items-center space-x-2"><span>🏢</span><span>Manila, Philippines</span></p>
      </div>

      <!-- Social Links -->
      <div>
        <h4 class="text-lg font-semibold text-white mb-3">Follow Us</h4>
        <div class="flex space-x-4">
          <a href="#" class="hover:text-blue-400">🌐</a>
          <a href="#" class="hover:text-blue-400">🐦</a>
          <a href="#" class="hover:text-blue-400">📘</a>
        </div>
      </div>
    </div>

    <!-- Bottom -->
    <div class="text-center text-sm text-gray-500 mt-8">
      © 2025 ASyne. All rights reserved.
    </div>
  </footer>

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true,
    });
  </script>

</body>
</html>
