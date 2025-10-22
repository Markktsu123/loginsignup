<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASyne</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  @vite('resources/css/app.css')
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  @vite('resources/css/login.css')
  <style>
    #modalContent {
      transform-origin: center;
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
      -webkit-transform: translateZ(0);
      transform: translateZ(0);
    }
  </style>
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
          <button onclick="confirmLogout()" class="w-full text-left px-4 py-3 text-gray-700 dark:text-gray-100 hover:bg-red-50 dark:hover:bg-gray-800 transition">Logout</button>
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

<!-- AI Type Selection Modal -->
<div id="aiTypeModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
  <div class="backdrop-blur-2xl bg-white/95 rounded-3xl shadow-2xl max-w-lg w-full mx-4 transform transition-transform duration-200 ease-out scale-75 opacity-0 border border-white/20 will-change-transform" id="modalContent">
    <!-- Close Button -->
    <div class="flex justify-end p-6 pb-0">
      <button id="closeModalBtn" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-all duration-200 hover:scale-110 group">
        <svg class="w-5 h-5 text-gray-600 group-hover:text-gray-800 transition-colors duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <div class="px-8 pb-8">
      <!-- Header -->
      <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
          </svg>
        </div>
        <h3 class="text-3xl font-bold text-gray-900 mb-3">Choose AI Type</h3>
        <p class="text-gray-600 text-lg">Select the type of AI detection you want to use</p>
      </div>
      
      <!-- AI Type Buttons -->
      <div class="space-y-4">
        <button id="azDetectionBtn" class="w-full p-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-2xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 flex items-center justify-center space-x-4 shadow-lg hover:shadow-xl hover:scale-[1.02] group">
          <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300">
            <span class="font-bold text-lg">A-Z</span>
          </div>
          <div class="text-left">
            <span class="font-semibold text-lg block">A-Z AI Detection</span>
            <span class="text-blue-100 text-sm">Alphabet recognition system</span>
          </div>
          <svg class="w-6 h-6 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
        
        <button id="gestureDetectionBtn" class="w-full p-6 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-2xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 flex items-center justify-center space-x-4 shadow-lg hover:shadow-xl hover:scale-[1.02] group">
          <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
          </div>
          <div class="text-left">
            <span class="font-semibold text-lg block">Gesture Detection</span>
            <span class="text-indigo-100 text-sm">Hand gesture recognition</span>
          </div>
          <svg class="w-6 h-6 opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="{{ asset('js/session-validator.js') }}"></script>
<script>
  AOS.init({ duration: 800, once: true });

  // Logout confirmation function
  function confirmLogout() {
    // Create confirmation modal
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]';
    modal.innerHTML = `
      <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl text-center">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
          <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
          </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Confirm Logout</h3>
        <p class="text-gray-600 text-base mb-6">Are you sure you want to logout? This will end your current session.</p>
        <div class="flex space-x-4">
          <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
            Cancel
          </button>
          <button onclick="performLogout()" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            Logout
          </button>
        </div>
      </div>
    `;
    
    document.body.appendChild(modal);
  }

  // Perform logout function
  function performLogout() {
    // Stop session monitoring
    if (window.sessionValidator) {
      window.sessionValidator.stopSessionMonitoring();
    }
    
    // Clear any cached data
    if (window.sessionValidator) {
      window.sessionValidator.clearCache();
    }
    
    // Create and submit logout form
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("logout") }}';
    form.innerHTML = `
      @csrf
    `;
    document.body.appendChild(form);
    form.submit();
  }

  // Modal functionality
  const modal = document.getElementById('aiTypeModal');
  const modalContent = document.getElementById('modalContent');
  const signLanguageBtn = document.getElementById('signLanguageBtn');
  const closeModalBtn = document.getElementById('closeModalBtn');
  const azDetectionBtn = document.getElementById('azDetectionBtn');
  const gestureDetectionBtn = document.getElementById('gestureDetectionBtn');

  // Open modal with optimized animation
  signLanguageBtn.addEventListener('click', () => {
    // Show modal and start animation in the same frame
    modal.classList.remove('hidden');
    
    // Use double requestAnimationFrame for guaranteed smooth animation
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        modalContent.classList.remove('scale-75', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
      });
    });
  });

  // Close modal with optimized animation
  function closeModal() {
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-75', 'opacity-0');
    
    // Hide modal after animation completes
    setTimeout(() => {
      modal.classList.add('hidden');
    }, 200); // Match the duration-200 class
  }

  closeModalBtn.addEventListener('click', closeModal);

  // Close modal when clicking outside
  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closeModal();
    }
  });

  // Handle AI type selection
  azDetectionBtn.addEventListener('click', () => {
    closeModal();
    // Redirect to A-Z AI Detection (you can change this URL as needed)
    window.open('https://172.20.10.2:5000/az-detection', '_blank');
  });

  gestureDetectionBtn.addEventListener('click', () => {
    closeModal();
    // Redirect to Gesture Detection (you can change this URL as needed)
    window.open('https://172.20.10.2:5000/gesture-detection', '_blank');
  });
</script>

</body>
</html>

