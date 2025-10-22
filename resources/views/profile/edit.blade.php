<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
          <span>{{ Auth::user()->fullName }}</span>
          <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg z-50 overflow-hidden">
          <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-gray-700 dark:text-gray-100 hover:bg-indigo-50 dark:hover:bg-gray-800 transition">Profile</a>
          <form method="POST" action="{{ route('logout') }}" id="logoutForm">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-3 text-gray-700 dark:text-gray-100 hover:bg-red-50 dark:hover:bg-gray-800 transition">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</nav>

<!-- Profile Page Content -->
<section class="min-h-screen flex flex-col items-center justify-center">
  <h2 class="text-3xl font-bold text-center text-indigo-600 mb-6">Profile Settings</h2>

  <!-- Profile Settings Panel -->
  <div class="w-full max-w-4xl">
    <div class="bg-white shadow-lg rounded-lg p-6">
      <!-- Success Messages -->
      @if(session('profile-updated'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
          <div class="flex items-center">
            <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span class="text-green-700 text-sm">{{ session('profile-updated') }}</span>
          </div>
        </div>
      @endif

      @if($errors->hasBag('updatePassword'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
          <div class="flex items-center">
            <svg class="w-4 h-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-red-700 text-sm">Password update failed. Please check your input.</span>
    </div>
        </div>
      @endif

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Left Side: Name and Email -->
        <div class="space-y-4 lg:border-r lg:border-gray-200 lg:pr-8">
          <h3 class="text-md font-semibold text-gray-800 mb-4">Personal Information</h3>
          
          <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <!-- Name Field -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
              <input id="name" name="name" type="text" value="{{ old('name', $user->fullName) }}" required autofocus autocomplete="name" tabindex="1"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all duration-200">
              @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Email Field -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="email" tabindex="2"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all duration-200">
              @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Save Button -->
            <div class="pt-2">
              <button type="button" onclick="confirmProfileUpdate()" tabindex="3" class="w-full px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-colors">
                Save Changes
              </button>
            </div>
          </form>
        </div>

        <!-- Right Side: Password Change -->
        <div class="space-y-4 lg:pl-8">
          <h3 class="text-md font-semibold text-gray-800 mb-4">Change Password</h3>
          
          <form id="passwordForm" method="post" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <!-- Current Password -->
            <div>
              <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
              <div class="relative">
                <input id="current_password" name="current_password" type="password" required autocomplete="current-password" tabindex="4"
                  class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all duration-200">
                <button type="button" onclick="togglePasswordVisibility('current_password', 'eyeIconCurrent')" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" tabindex="-1">
                  <svg id="eyeIconCurrent" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
              @error('current_password', 'updatePassword')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- New Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
              <div class="relative">
                <input id="password" name="password" type="password" required autocomplete="new-password" tabindex="5"
                  class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all duration-200">
                <button type="button" onclick="togglePasswordVisibility('password', 'eyeIconNew')" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" tabindex="-1">
                  <svg id="eyeIconNew" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
              
              <!-- Real-time Password Validation -->
              <div id="passwordValidation" class="mt-2 space-y-1">
                <div id="lengthCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
                  <div id="lengthIcon" class="w-3 h-3 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                    <svg class="w-2 h-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </div>
                  <span class="text-gray-600 font-medium text-xs">At least 8 characters</span>
                </div>
                <div id="uppercaseCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
                  <div id="uppercaseIcon" class="w-3 h-3 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                    <svg class="w-2 h-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </div>
                  <span class="text-gray-600 font-medium text-xs">One uppercase letter</span>
                </div>
                <div id="lowercaseCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
                  <div id="lowercaseIcon" class="w-3 h-3 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                    <svg class="w-2 h-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </div>
                  <span class="text-gray-600 font-medium text-xs">One lowercase letter</span>
                </div>
                <div id="numberCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
                  <div id="numberIcon" class="w-3 h-3 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                    <svg class="w-2 h-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </div>
                  <span class="text-gray-600 font-medium text-xs">One number</span>
                </div>
                <div id="specialCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
                  <div id="specialIcon" class="w-3 h-3 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                    <svg class="w-2 h-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                  </div>
                  <span class="text-gray-600 font-medium text-xs">One special character</span>
      </div>
    </div>

              @error('password', 'updatePassword')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Confirm New Password -->
            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
              <div class="relative">
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" tabindex="6"
                  class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all duration-200">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eyeIconConfirm')" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700" tabindex="-1">
                  <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </button>
              </div>
              @error('password_confirmation', 'updatePassword')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Save Password Button -->
            <div class="pt-2">
              <button type="button" onclick="confirmPasswordChange()" tabindex="7" class="w-full px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-colors">
                Change Password
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</section>


<!-- Profile Update Confirmation Modal -->
<div id="profileConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4 shadow-lg">
    <h3 class="text-lg font-bold text-gray-800 mb-3 text-center">Confirm Profile Update</h3>
    <p class="text-gray-600 text-sm text-center mb-4">Are you sure you want to save these changes to your profile?</p>
    
    <div class="flex space-x-3">
      <button type="button" onclick="closeProfileConfirmModal()" tabindex="1" class="flex-1 px-3 py-2 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 transition-colors">
        Cancel
      </button>
      <button type="button" onclick="submitProfileForm()" tabindex="2" class="flex-1 px-3 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-colors">
        Confirm
      </button>
    </div>
  </div>
</div>

<!-- Password Change Confirmation Modal -->
<div id="passwordConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl">
    <div class="text-center">
      <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-6">
        <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
        </svg>
      </div>
      <h3 class="text-2xl font-bold text-gray-900 mb-4">Confirm Password Change</h3>
      <p class="text-gray-600 text-base mb-6">Are you sure you want to change your password? You will be logged out after the password change.</p>
      
      <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-yellow-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
          <p class="text-yellow-800 text-sm">
            <strong>Important:</strong> You will be automatically logged out and need to sign in again with your new password.
          </p>
        </div>
      </div>
      
      <div class="flex space-x-4">
        <button type="button" onclick="closePasswordConfirmModal()" tabindex="1" class="flex-1 px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
          Cancel
        </button>
        <button type="button" onclick="submitPasswordForm()" tabindex="2" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
          Confirm
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Password Change Success Warning Modal -->
<div id="passwordSuccessModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4 shadow-lg">
    <div class="text-center">
      <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      <h3 class="text-lg font-bold text-gray-900 mb-2">Password Changed Successfully!</h3>
      <p class="text-gray-600 text-sm mb-4">
        For security reasons, you will be automatically logged out and need to sign in again with your new password to complete the password change process.
      </p>
      <div class="bg-yellow-50 border border-yellow-200 rounded-md p-3 mb-4">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
          </svg>
          <p class="text-yellow-800 text-sm">
            <strong>Important:</strong> Please remember your new password. You will need it to log back in.
          </p>
        </div>
      </div>
      <button type="button" onclick="logoutAndRedirect()" tabindex="1" class="w-full px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition-colors">
        Continue to Login
      </button>
    </div>
  </div>
</div>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="{{ asset('js/session-validator.js') }}"></script>
<script>
  AOS.init({ duration: 800, once: true });

  // Enhanced logout handling
  document.getElementById('logoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Stop session monitoring
    if (window.sessionValidator) {
      window.sessionValidator.stopSessionMonitoring();
    }
    
    // Submit logout form
    this.submit();
  });

  // Password visibility toggle function
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

  // Modal functions
  function openPasswordModal() {
    document.getElementById('passwordModal').classList.remove('hidden');
    document.getElementById('passwordModal').classList.add('flex');
    
    // Focus trap: only allow tabbing within the modal
    trapFocusInModal('passwordModal');
  }

  function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
    document.getElementById('passwordModal').classList.remove('flex');
    // Reset form
    document.getElementById('passwordForm').reset();
    // Remove focus trap
    removeFocusTrap();
  }

  function confirmPasswordChange() {
    // Open custom confirmation modal
    document.getElementById('passwordConfirmModal').classList.remove('hidden');
    document.getElementById('passwordConfirmModal').classList.add('flex');
    // Focus trap for confirmation modal
    trapFocusInModal('passwordConfirmModal');
  }

  function closePasswordConfirmModal() {
    document.getElementById('passwordConfirmModal').classList.add('hidden');
    document.getElementById('passwordConfirmModal').classList.remove('flex');
    // Remove focus trap
    removeFocusTrap();
  }

  function openPasswordSuccessModal() {
    document.getElementById('passwordSuccessModal').classList.remove('hidden');
    document.getElementById('passwordSuccessModal').classList.add('flex');
    // Focus trap for success modal
    trapFocusInModal('passwordSuccessModal');
  }

  function closePasswordSuccessModal() {
    document.getElementById('passwordSuccessModal').classList.add('hidden');
    document.getElementById('passwordSuccessModal').classList.remove('flex');
    // Remove focus trap
    removeFocusTrap();
  }

  function logoutAndRedirect() {
    // Logout the user
    fetch('{{ route("logout") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({})
    }).then(() => {
      // Redirect to login page with success message
      window.location.href = '{{ route("login") }}?password_changed=true';
    }).catch(() => {
      // Fallback: direct redirect
      window.location.href = '{{ route("login") }}?password_changed=true';
    });
  }

  // Focus trap variables
  let focusableElements = [];
  let firstFocusableElement = null;
  let lastFocusableElement = null;
  let currentModal = null;

  // Function to trap focus within a modal
  function trapFocusInModal(modalId) {
    const modal = document.getElementById(modalId);
    currentModal = modalId;
    
    // Get all focusable elements within the modal
    focusableElements = modal.querySelectorAll(
      'input:not([disabled]):not([tabindex="-1"]), ' +
      'button:not([disabled]):not([tabindex="-1"]), ' +
      'textarea:not([disabled]):not([tabindex="-1"]), ' +
      'select:not([disabled]):not([tabindex="-1"]), ' +
      'a[href]:not([tabindex="-1"])'
    );
    
    firstFocusableElement = focusableElements[0];
    lastFocusableElement = focusableElements[focusableElements.length - 1];
    
    // Focus the first element
    if (firstFocusableElement) {
      firstFocusableElement.focus();
    }
    
    // Add keydown event listener for tab trapping
    document.addEventListener('keydown', handleTabKey);
  }

  // Function to remove focus trap
  function removeFocusTrap() {
    document.removeEventListener('keydown', handleTabKey);
    focusableElements = [];
    firstFocusableElement = null;
    lastFocusableElement = null;
    currentModal = null;
  }

  // Function to handle tab key trapping
  function handleTabKey(e) {
    if (e.key === 'Tab' && currentModal) {
      if (e.shiftKey) {
        // Shift + Tab (backward)
        if (document.activeElement === firstFocusableElement) {
          e.preventDefault();
          lastFocusableElement.focus();
        }
      } else {
        // Tab (forward)
        if (document.activeElement === lastFocusableElement) {
          e.preventDefault();
          firstFocusableElement.focus();
        }
      }
    }
  }

  function confirmProfileUpdate() {
    // Check if there are any changes
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const originalName = '{{ $user->fullName }}';
    const originalEmail = '{{ $user->email }}';
    
    const nameChanged = nameInput.value !== originalName;
    const emailChanged = emailInput.value !== originalEmail;
    
    if (!nameChanged && !emailChanged) {
      alert('No changes detected. Please modify your name or email before saving.');
      return;
    }
    
    // Open confirmation modal
    document.getElementById('profileConfirmModal').classList.remove('hidden');
    document.getElementById('profileConfirmModal').classList.add('flex');
    // Focus trap for confirmation modal
    trapFocusInModal('profileConfirmModal');
  }

  function closeProfileConfirmModal() {
    document.getElementById('profileConfirmModal').classList.add('hidden');
    document.getElementById('profileConfirmModal').classList.remove('flex');
    // Remove focus trap
    removeFocusTrap();
  }

  function submitProfileForm() {
    document.querySelector('form[action="{{ route('profile.update') }}"]').submit();
  }

  function submitPasswordForm() {
    // Close the confirmation modal first
    closePasswordConfirmModal();
    
    // Get form data for debugging
    const form = document.getElementById('passwordForm');
    const formData = new FormData(form);
    
    // Log form data to console for debugging
    console.log('Submitting password form with data:');
    for (let [key, value] of formData.entries()) {
      console.log(key + ': ' + (key.includes('password') ? '[HIDDEN]' : value));
    }
    
    // Check individual field values
    const currentPassword = document.getElementById('current_password').value;
    const newPassword = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    
    console.log('Field values check:');
    console.log('Current password length:', currentPassword.length);
    console.log('New password length:', newPassword.length);
    console.log('Confirm password length:', confirmPassword.length);
    
    // Check if any field is empty
    if (currentPassword.length === 0) {
      console.error('Current password is empty!');
      showValidationError('Current password cannot be empty.', 'current_password');
      return;
    }
    
    if (newPassword.length === 0) {
      console.error('New password is empty!');
      showValidationError('New password cannot be empty.', 'password');
      return;
    }
    
    if (confirmPassword.length === 0) {
      console.error('Confirm password is empty!');
      showValidationError('Confirm password cannot be empty.', 'password_confirmation');
      return;
    }
    
    // Check if passwords match
    if (newPassword !== confirmPassword) {
      console.error('Passwords do not match!');
      showValidationError('New password and confirm password do not match.', 'password_confirmation');
      return;
    }
    
    // Check if new password meets all requirements
    const hasLength = newPassword.length >= 8;
    const hasUppercase = /[A-Z]/.test(newPassword);
    const hasLowercase = /[a-z]/.test(newPassword);
    const hasNumber = /\d/.test(newPassword);
    const hasSpecial = /[!@#$%^&*()_+\-=\[\]{}|;:"\'<>,.?\/]/.test(newPassword);
    
    if (!hasLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecial) {
      console.error('New password does not meet requirements!');
      showValidationError('New password must contain at least 8 characters, one uppercase letter, one lowercase letter, one number, and one special character.', 'password');
      return;
    }
    
    console.log('All validations passed, submitting form...');
    
    // Ensure form has correct method and action
    console.log('Form method:', form.method);
    console.log('Form action:', form.action);
    
    // Submit the form
    form.submit();
  }

  // Helper function to show validation errors
  function showValidationError(message, fieldId) {
    // Create a temporary error message element
    const errorDiv = document.createElement('div');
    errorDiv.className = 'fixed top-4 right-4 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300';
    errorDiv.innerHTML = `
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span>${message}</span>
      </div>
    `;
    
    document.body.appendChild(errorDiv);
    
    // Highlight the field
    const field = document.getElementById(fieldId);
    if (field) {
      field.classList.add('border-red-500', 'bg-red-50');
      field.focus();
    }
    
    // Remove error message after 5 seconds
    setTimeout(() => {
      errorDiv.remove();
      if (field) {
        field.classList.remove('border-red-500', 'bg-red-50');
      }
    }, 5000);
  }


  function updateValidationIcon(iconId, checkId, isValid) {
    const iconContainer = document.getElementById(iconId);
    const checkContainer = document.getElementById(checkId);
    const textSpan = checkContainer.querySelector('span:last-child');
    
    if (isValid) {
      // Success state - green with checkmark
      iconContainer.className = 'w-3 h-3 lg:w-4 lg:h-4 mr-2 rounded-full border-2 border-green-500 bg-green-500 flex items-center justify-center transition-all duration-300 ease-in-out transform scale-110 flex-shrink-0';
      iconContainer.innerHTML = `
        <svg class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
      `;
      textSpan.className = 'text-green-700 font-semibold text-xs lg:text-sm';
      checkContainer.className = 'flex items-center text-sm transition-all duration-300 ease-in-out transform scale-105';
    } else {
      // Error state - gray with X
      iconContainer.className = 'w-3 h-3 lg:w-4 lg:h-4 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0';
      iconContainer.innerHTML = `
        <svg class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      `;
      textSpan.className = 'text-gray-600 font-medium text-xs lg:text-sm';
      checkContainer.className = 'flex items-center text-sm transition-all duration-300 ease-in-out';
    }
  }

  // Check if password was just changed and show success modal
  @if(session('password-changed'))
    document.addEventListener('DOMContentLoaded', function() {
      openPasswordSuccessModal();
    });
  @endif

  // Close modals when clicking outside
  document.addEventListener('click', function(e) {
    const passwordModal = document.getElementById('passwordModal');
    const passwordConfirmModal = document.getElementById('passwordConfirmModal');
    const passwordSuccessModal = document.getElementById('passwordSuccessModal');
    const profileConfirmModal = document.getElementById('profileConfirmModal');
    
    if (e.target === passwordModal) {
      closePasswordModal();
    }
    if (e.target === passwordConfirmModal) {
      closePasswordConfirmModal();
    }
    if (e.target === passwordSuccessModal) {
      closePasswordSuccessModal();
    }
    if (e.target === profileConfirmModal) {
      closeProfileConfirmModal();
    }
  });

  // Close modals with Escape key (separate from tab handling)
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && currentModal) {
      e.preventDefault();
      if (currentModal === 'passwordModal') {
        closePasswordModal();
      } else if (currentModal === 'passwordConfirmModal') {
        closePasswordConfirmModal();
      } else if (currentModal === 'passwordSuccessModal') {
        closePasswordSuccessModal();
      } else if (currentModal === 'profileConfirmModal') {
        closeProfileConfirmModal();
      }
    }
  });

  // Real-time password validation for profile password modal
  document.getElementById("password").addEventListener("input", function() {
    const password = this.value;
    
    // Clear any error highlighting first
    this.classList.remove("border-red-500", "bg-red-50");
    
    // Check each requirement
    const hasLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /\d/.test(password);
    const hasSpecial = /[!@#$%^&*()_+\-=\[\]{}|;:"\'<>,.?\/]/.test(password);
    
    // Update validation icons
    updateValidationIcon("lengthIcon", "lengthCheck", hasLength);
    updateValidationIcon("uppercaseIcon", "uppercaseCheck", hasUppercase);
    updateValidationIcon("lowercaseIcon", "lowercaseCheck", hasLowercase);
    updateValidationIcon("numberIcon", "numberCheck", hasNumber);
    updateValidationIcon("specialIcon", "specialCheck", hasSpecial);
    
    // Check if all requirements are met
    const allValid = hasLength && hasUppercase && hasLowercase && hasNumber && hasSpecial;
    
    // Update textbox styling
    if (password.length > 0) {
      if (allValid) {
        this.classList.remove("border-gray-300");
        this.classList.add("border-green-500", "bg-green-50");
      } else {
        this.classList.remove("border-gray-300", "border-green-500", "bg-green-50");
        this.classList.add("border-red-500", "bg-red-50");
      }
    } else {
      this.classList.remove("border-red-500", "border-green-500", "bg-red-50", "bg-green-50");
      this.classList.add("border-gray-300");
    }
    
    // Update confirm password validation if it has content
    const confirmPassword = document.getElementById("password_confirmation").value;
    if (confirmPassword.length > 0) {
      validateConfirmPassword();
    }
  });


  // Real-time current password validation
  document.getElementById("current_password").addEventListener("input", function() {
    const currentPassword = this.value;
    
    // Clear any error highlighting
    this.classList.remove("border-red-500", "bg-red-50");
    
    // Update textbox styling
    if (currentPassword.length > 0) {
      this.classList.remove("border-gray-300");
      this.classList.add("border-blue-500", "bg-blue-50");
    } else {
      this.classList.remove("border-blue-500", "bg-blue-50");
      this.classList.add("border-gray-300");
    }
  });

  // Real-time confirm password validation
  document.getElementById("password_confirmation").addEventListener("input", function() {
    validateConfirmPassword();
  });

  // Function to validate confirm password
  function validateConfirmPassword() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("password_confirmation").value;
    const confirmField = document.getElementById("password_confirmation");
    
    // Clear any error highlighting first
    confirmField.classList.remove("border-red-500", "bg-red-50");
    
    if (confirmPassword.length > 0) {
      if (password === confirmPassword && password.length > 0) {
        confirmField.classList.remove("border-gray-300");
        confirmField.classList.add("border-green-500", "bg-green-50");
      } else {
        confirmField.classList.remove("border-gray-300", "border-green-500", "bg-green-50");
        confirmField.classList.add("border-red-500", "bg-red-50");
      }
    } else {
      confirmField.classList.remove("border-red-500", "border-green-500", "bg-red-50", "bg-green-50");
      confirmField.classList.add("border-gray-300");
    }
  }

  // Name validation
  document.getElementById("name").addEventListener("input", function() {
    const name = this.value;
    const nameRegex = /^[a-zA-Z\s]+$/;
    const isValid = nameRegex.test(name) && name.length >= 2;
    
    if (name.length > 0) {
      if (isValid) {
        this.classList.remove("border-gray-300", "border-red-500");
        this.classList.add("border-green-500", "bg-green-50");
      } else {
        this.classList.remove("border-gray-300", "border-green-500", "bg-green-50");
        this.classList.add("border-red-500", "bg-red-50");
      }
    } else {
      this.classList.remove("border-red-500", "border-green-500", "bg-red-50", "bg-green-50");
      this.classList.add("border-gray-300");
    }
  });

  // Prevent special characters and numbers in name field
  document.getElementById("name").addEventListener("keypress", function(e) {
    // Allow letters, spaces, and control keys (backspace, delete, tab, etc.)
    const allowedChars = /[a-zA-Z\s]/;
    const isControlKey = e.ctrlKey || e.altKey || e.metaKey || 
                        e.key === 'Backspace' || e.key === 'Delete' ||
                        e.key === 'Tab' || e.key === 'Enter' ||
                        e.key === 'ArrowLeft' || e.key === 'ArrowRight' ||
                        e.key === 'Home' || e.key === 'End';

    if (!allowedChars.test(e.key) && !isControlKey) {
      e.preventDefault();
    }
  });

  // Email validation
  document.getElementById("email").addEventListener("input", function() {
    const email = this.value;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
    const isValid = emailRegex.test(email);
    
    if (email.length > 0) {
      if (isValid) {
        this.classList.remove("border-gray-300", "border-red-500");
        this.classList.add("border-green-500", "bg-green-50");
      } else {
        this.classList.remove("border-gray-300", "border-green-500", "bg-green-50");
        this.classList.add("border-red-500", "bg-red-50");
      }
    } else {
      this.classList.remove("border-red-500", "border-green-500", "bg-red-50", "bg-green-50");
      this.classList.add("border-gray-300");
    }
  });

  // Prevent special characters and numbers in name field
  document.getElementById("name").addEventListener("keypress", function(e) {
    const allowedChars = /[a-zA-Z\s]/;
    const isControlKey = e.ctrlKey || e.altKey || e.metaKey || 
                        e.key === 'Backspace' || e.key === 'Delete' ||
                        e.key === 'Tab' || e.key === 'Enter' ||
                        e.key === 'ArrowLeft' || e.key === 'ArrowRight' ||
                        e.key === 'Home' || e.key === 'End';

    if (!allowedChars.test(e.key) && !isControlKey) {
      e.preventDefault();
    }
  });
</script>

</body>
</html>
