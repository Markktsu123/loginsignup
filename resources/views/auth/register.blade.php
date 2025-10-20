<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - ASyne</title>
  @vite('resources/css/app.css')

  <!-- AOS Animation CSS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

</head>
<body class="font-sans text-gray-800 bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 relative h-screen overflow-hidden">

  <!-- Background Shapes -->
  <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
  <div class="absolute top-40 -right-20 w-80 h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>

  <!-- Signup Section -->
  <section class="h-screen flex flex-col lg:flex-row items-center justify-center p-4 sm:p-6 relative z-10">

    <!-- Left Side -->
    <div class="hidden lg:flex flex-col items-center justify-center lg:w-1/2 xl:w-3/5 space-y-4 xl:space-y-6 text-center px-6 xl:px-10" data-aos="fade-right">
      <img src="/images/logo.png" alt="ASyne Logo" class="w-20 h-20 xl:w-24 xl:h-24 mb-2 xl:mb-4">
      <h1 class="text-3xl xl:text-4xl font-extrabold text-gray-800">Welcome to <span class="text-blue-600">ASyne</span></h1>
      <p class="text-gray-700 text-base xl:text-lg max-w-sm xl:max-w-md">
        Bridging the gap between the deaf and hearing communities.
        Join us in making communication seamless, accessible, and inclusive.
      </p>
    </div>

    <!-- Right Side (Form) -->
    <div class="bg-white shadow-2xl rounded-2xl p-6 lg:p-8 w-full max-w-md lg:w-2/5 mx-auto lg:mx-0 overflow-y-auto max-h-[90vh]" data-aos="fade-up">
      <h2 class="text-2xl lg:text-3xl font-extrabold text-center text-gray-800 mb-2 tracking-wide">Create Account</h2>
      <p class="text-center text-gray-600 mb-4 lg:mb-6 text-sm">Fill in your details to get started 🚀</p>
      <hr class="border-gray-300 mb-4 lg:mb-6">

      <!-- Laravel Errors -->
      @if ($errors->any())
        <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 text-sm font-medium">
          <ul class="list-disc pl-4">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form id="signupForm" method="POST" action="{{ route('register') }}" class="space-y-3 lg:space-y-4">
        @csrf

        <!-- Full Name -->
        <div>
          <label for="fullName" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
          <input id="fullName" type="text" name="fullName" value="{{ old('fullName') }}" autocomplete="name" required tabindex="1"
            class="w-full px-3 py-2 lg:px-4 lg:py-3 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200">
          @error('fullName')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required tabindex="2"
            class="w-full px-3 py-2 lg:px-4 lg:py-3 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200">
          <div id="emailError" class="mt-1 lg:mt-2 p-2 lg:p-3 bg-red-50 border border-red-200 rounded-lg hidden">
            <div class="flex items-start">
              <svg class="w-3 h-3 lg:w-4 lg:h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-red-700 text-xs lg:text-sm font-medium">Email must be from gmail.com, outlook.com, or yahoo.com</span>
            </div>
          </div>
          <div id="emailSuccess" class="mt-1 lg:mt-2 p-2 lg:p-3 bg-green-50 border border-green-200 rounded-lg hidden">`=9
          </div>
          @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <div class="relative">
            <input id="password" type="password" name="password" autocomplete="new-password" required tabindex="3"
              class="w-full px-3 py-2 lg:px-4 lg:py-3 pr-10 lg:pr-12 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200">
            <button type="button" onclick="togglePasswordVisibility('password', 'eyeIconPassword')" class="absolute right-2 lg:right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none p-1 rounded-md hover:bg-gray-100 transition-colors duration-200" tabindex="-1">
              <svg id="eyeIconPassword" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
          <!-- Real-time Password Validation -->
          <div id="passwordValidation" class="mt-2 lg:mt-3 space-y-1 lg:space-y-2">
            <div id="lengthCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
              <div id="lengthIcon" class="w-3 h-3 lg:w-4 lg:h-4 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                <svg class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </div>
              <span class="text-gray-600 font-medium text-xs lg:text-sm">At least 8 characters</span>
            </div>
            <div id="uppercaseCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
              <div id="uppercaseIcon" class="w-3 h-3 lg:w-4 lg:h-4 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                <svg class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </div>
              <span class="text-gray-600 font-medium text-xs lg:text-sm">One uppercase letter</span>
            </div>
            <div id="lowercaseCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
              <div id="lowercaseIcon" class="w-3 h-3 lg:w-4 lg:h-4 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                <svg class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </div>
              <span class="text-gray-600 font-medium text-xs lg:text-sm">One lowercase letter</span>
            </div>
            <div id="numberCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
              <div id="numberIcon" class="w-3 h-3 lg:w-4 lg:h-4 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                <svg class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </div>
              <span class="text-gray-600 font-medium text-xs lg:text-sm">One number</span>
            </div>
            <div id="specialCheck" class="flex items-center text-sm transition-all duration-300 ease-in-out">
              <div id="specialIcon" class="w-3 h-3 lg:w-4 lg:h-4 mr-2 rounded-full border-2 border-gray-300 bg-gray-50 flex items-center justify-center transition-all duration-300 ease-in-out flex-shrink-0">
                <svg class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </div>
              <span class="text-gray-600 font-medium text-xs lg:text-sm">One special character</span>
            </div>
          </div>
          @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
          <div class="relative">
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required tabindex="4"
              class="w-full px-3 py-2 lg:px-4 lg:py-3 pr-10 lg:pr-12 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-200">
            <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'eyeIconConfirm')" class="absolute right-2 lg:right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none p-1 rounded-md hover:bg-gray-100 transition-colors duration-200" tabindex="-1">
              <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Sign Up Button -->
        <button type="submit" tabindex="5"
          class="w-full py-2 lg:py-3 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
          SIGN UP
        </button>

        <!-- Login Redirect -->
        <p class="mt-4 lg:mt-6 text-center text-xs lg:text-sm text-gray-600">
          Already have an account?
          <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline transition-colors duration-200">Login</a>
        </p>
      </form>
    </div>
  </section>

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
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

    // Full Name validation
    document.getElementById("fullName").addEventListener("input", function() {
      const fullName = this.value;
      const nameRegex = /^[a-zA-Z\s]+$/;
      const isValid = nameRegex.test(fullName) && fullName.length >= 2;
      
      if (fullName.length > 0) {
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

    // Email validation
    document.getElementById("email").addEventListener("input", function() {
      const email = this.value;
      const emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
      const isValid = emailRegex.test(email);
      
      const emailError = document.getElementById("emailError");
      const emailSuccess = document.getElementById("emailSuccess");
      
      if (email.length > 0) {
        if (isValid) {
          // Hide error message and show success message
          emailError.classList.add("hidden");
          emailSuccess.classList.remove("hidden");
          // Green textbox
          this.classList.remove("border-gray-300", "border-red-500");
          this.classList.add("border-green-500", "bg-green-50");
        } else {
          // Show error message and hide success message
          emailError.classList.remove("hidden");
          emailSuccess.classList.add("hidden");
          // Red textbox
          this.classList.remove("border-gray-300", "border-green-500", "bg-green-50");
          this.classList.add("border-red-500", "bg-red-50");
        }
      } else {
        // Hide both messages and reset textbox
        emailError.classList.add("hidden");
        emailSuccess.classList.add("hidden");
        this.classList.remove("border-red-500", "border-green-500", "bg-red-50", "bg-green-50");
        this.classList.add("border-gray-300");
      }
    });

    // Password validation
    document.getElementById("password").addEventListener("input", function() {
      const password = this.value;
      
      // Check each requirement
      const hasLength = password.length >= 8;
      const hasUppercase = /[A-Z]/.test(password);
      const hasLowercase = /[a-z]/.test(password);
      const hasNumber = /\d/.test(password);
      const hasSpecial = /[@$!%*?&#^()_\-+=\[\]{}|\\:;"\'<>,.\/]/.test(password);
      
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

    // Confirm password validation
    document.getElementById("password_confirmation").addEventListener("input", function() {
      const password = document.getElementById("password").value;
      const confirmPassword = this.value;
      
      if (confirmPassword.length > 0) {
        if (password === confirmPassword && password.length > 0) {
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

    // Prevent special characters and numbers in full name field
    document.getElementById("fullName").addEventListener("keypress", function(e) {
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

    // Add real-time validation to email field
    document.getElementById("email").addEventListener("input", function() {
      const email = this.value;
      const emailError = document.getElementById("emailError");
      const emailSuccess = document.getElementById("emailSuccess");
      const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
      
      if (email.length > 0) {
        if (emailPattern.test(email)) {
          emailError.classList.add("hidden");
          emailSuccess.classList.remove("hidden");
          setTimeout(() => {
            emailSuccess.classList.add("animate-pulse");
          }, 100);
        } else {
          emailError.classList.remove("hidden");
          emailSuccess.classList.add("hidden");
          setTimeout(() => {
            emailError.classList.add("animate-pulse");
          }, 100);
        }
      } else {
        emailError.classList.add("hidden");
        emailSuccess.classList.add("hidden");
        emailError.classList.remove("animate-pulse");
        emailSuccess.classList.remove("animate-pulse");
      }
    });

    // Add real-time validation to password field
    document.getElementById("password").addEventListener("input", function() {
      const password = this.value;
      const isValid = validatePassword(password);
      
      // Hide/show general password error with animation
      const passwordError = document.getElementById("passwordError");
      if (password.length > 0 && !isValid) {
        passwordError.classList.remove("hidden");
        setTimeout(() => {
          passwordError.classList.add("animate-pulse");
        }, 100);
      } else {
        passwordError.classList.add("hidden");
        passwordError.classList.remove("animate-pulse");
      }
    });

    // Real-time confirm password validation
    document.getElementById("password_confirmation").addEventListener("input", function() {
      const password = document.getElementById("password").value;
      const confirmPassword = this.value;
      const confirmError = document.getElementById("confirmError");
      const confirmSuccess = document.getElementById("confirmSuccess");
      
      if (confirmPassword.length > 0) {
        if (password === confirmPassword) {
          confirmError.classList.add("hidden");
          confirmSuccess.classList.remove("hidden");
          setTimeout(() => {
            confirmSuccess.classList.add("animate-pulse");
          }, 100);
        } else {
          confirmError.classList.remove("hidden");
          confirmSuccess.classList.add("hidden");
          setTimeout(() => {
            confirmError.classList.add("animate-pulse");
          }, 100);
        }
      } else {
        confirmError.classList.add("hidden");
        confirmSuccess.classList.add("hidden");
        confirmError.classList.remove("animate-pulse");
        confirmSuccess.classList.remove("animate-pulse");
      }
    });

    // Validation + allow submit if valid
    document.getElementById("signupForm").addEventListener("submit", function (e) {
      let valid = true;


      // Email validation - only allow gmail, outlook, and yahoo
      const email = document.getElementById("email").value;
      const emailError = document.getElementById("emailError");
      const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
      if (!emailPattern.test(email)) {
        emailError.classList.remove("hidden");
        valid = false;
      } else {
        emailError.classList.add("hidden");
      }

      // Password validation - uppercase, lowercase, number, special character, min 8 chars
      const password = document.getElementById("password").value;
      const passwordError = document.getElementById("passwordError");
      const isValidPassword = validatePassword(password);
      
      if (!isValidPassword) {
        passwordError.classList.remove("hidden");
        valid = false;
      } else {
        passwordError.classList.add("hidden");
      }

      // Confirm password validation
      const confirmPassword = document.getElementById("password_confirmation").value;
      const confirmError = document.getElementById("confirmError");
      if (password !== confirmPassword) {
        confirmError.classList.remove("hidden");
        valid = false;
      } else {
        confirmError.classList.add("hidden");
      }

      if (!valid) {
        e.preventDefault(); // block submission if invalid
      }
    });
  </script>

</body>
</html>
