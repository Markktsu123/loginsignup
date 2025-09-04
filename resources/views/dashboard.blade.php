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

<!-- Navbar with Profile Dropdown -->
<nav class="fixed top-0 left-0 w-full backdrop-blur-xl bg-white/50 border-b border-gray-200 shadow-md z-50">
  <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-4">

    <!-- Logo -->
    <a href="#about" class="text-2xl font-extrabold text-indigo-600 tracking-tight">ASyne</a>

    <!-- Links -->
    <div class="flex items-center space-x-8 relative">
         <a href="#about" class="text-gray-700 font-medium hover:text-indigo-600 transition">Home</a>
      <a href="#about" class="text-gray-700 font-medium hover:text-indigo-600 transition">About</a>
      <a href="#faqs" class="text-gray-700 font-medium hover:text-indigo-600 transition">FAQ’s</a>
      <a href="#contacts" class="text-gray-700 font-medium hover:text-indigo-600 transition">Contacts</a>

      <!-- Profile Dropdown -->
      @auth
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
      @endauth
    </div>
  </div>
</nav>

<!-- About Section -->
<section id="about" class="min-h-screen px-6 py-28 flex flex-col items-center justify-center space-y-10">
  <div class="max-w-6xl w-full" data-aos="fade-up">

    <div class="grid md:grid-cols-2 gap-10 items-center mb-16">
      <div>
        <h2 class="text-4xl md:text-5xl font-extrabold text-indigo-600 mb-4">
          Welcome to <span class="font-bold text-gray-900">ASyne,</span>
        </h2>
        <p class="text-xl md:text-2xl font-medium text-gray-900 leading-snug italic mb-6">
          ‘Bridging Silence, Building<br>Connection.’
        </p>

        <!-- Buttons: Sign Language & Text-to-Speech -->
        <div class="flex flex-wrap gap-4 mt-4">
          <button id="signLanguageBtn" class="px-6 py-3 rounded-xl bg-blue-500 text-white font-semibold shadow-md hover:shadow-lg hover:scale-[1.02] transition duration-200">
            Sign Language Translator
          </button>

          <!-- Fixed Text-to-Speech Button -->
          <a href="{{ route('speech.conversion') }}" 
             class="px-6 py-3 rounded-xl bg-indigo-500 text-white font-semibold shadow-md hover:shadow-lg hover:scale-[1.02] transition duration-200 inline-block text-center">
            Text-to-Speech
          </a>
        </div>

      </div>
      <div class="flex justify-center md:justify-end">
        <img src="/images/logo.png" alt="ASyne Logo" class="w-40 md:w-56">
      </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-10 flex flex-col items-center justify-center hover:scale-[1.02] transition-transform duration-300" data-aos="zoom-in">
        <img src="/images/11.png" alt="Feature 1" class="w-10 h-10 mb-4">
        <p class="text-gray-700 text-center text-sm">We want to break communication barriers between the deaf and hearing community by providing real-time sign-to-text and sign-to-speech translation.</p>
      </div>
      <div class="backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-10 flex flex-col items-center justify-center hover:scale-[1.02] transition-transform duration-300" data-aos="zoom-in" data-aos-delay="100">
        <img src="/images/22.png" alt="Feature 2" class="w-10 h-10 mb-4">
        <p class="text-gray-700 text-center text-sm">We want to empower deaf individuals to communicate independently in schools, workplaces, and daily life without always needing an interpreter.</p>
      </div>
      <div class="backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-10 flex flex-col items-center justify-center hover:scale-[1.02] transition-transform duration-300" data-aos="zoom-in" data-aos-delay="200">
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

  // Placeholder JS for buttons
  document.getElementById('signLanguageBtn').addEventListener('click', () => {
    alert('Sign Language Translator will open here!');
    // Hook your ML model or redirect to translator page
  });

  document.getElementById('textToSpeechBtn').addEventListener('click', () => {
    const text = prompt('Enter text to read aloud:');
    if (text) {
      const msg = new SpeechSynthesisUtterance(text);
      msg.lang = 'en-US';
      window.speechSynthesis.speak(msg);
    }
  });
</script>

</body>
</html>
