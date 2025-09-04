<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - ASyne</title>
  @vite('resources/css/app.css')

  <!-- AOS Animation CSS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Heroicons (Feather for eye icons) -->
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="font-sans text-gray-800 bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 relative overflow-hidden">

  <!-- Background Shapes -->
  <div class="absolute -top-20 -left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
  <div class="absolute top-40 -right-20 w-80 h-80 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>

  <!-- Signup Section -->
  <section class="min-h-screen flex flex-col md:flex-row items-center justify-center p-6 relative z-10">

    <!-- Left Side -->
    <div class="hidden md:flex flex-col items-center justify-center w-1/2 space-y-6 text-center p-10" data-aos="fade-right">
      <img src="/images/logo.png" alt="ASyne Logo" class="w-28 h-28 mb-4">
      <h1 class="text-4xl font-extrabold text-gray-800">Welcome to <span class="text-blue-600">ASyne</span></h1>
      <p class="text-gray-700 text-lg max-w-md">
        Bridging the gap between the deaf and hearing communities.
        Join us in making communication seamless, accessible, and inclusive.
      </p>
    </div>

    <!-- Right Side (Form) -->
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-full max-w-md border border-gray-200" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-2 tracking-wide">Create Account</h2>
      <p class="text-center text-gray-600 mb-6 text-sm">Fill in your details to get started 🚀</p>
      <hr class="border-gray-300 mb-6">

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

      <form id="signupForm" method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Full Name -->
        <div>
          <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
          <input id="fullName" type="text" name="fullName" value="{{ old('fullName') }}" autocomplete="name" required
            class="mt-1 w-full px-4 py-2 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
          @error('fullName')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required
            class="mt-1 w-full px-4 py-2 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none">
          <p id="emailError" class="text-red-500 text-sm mt-1 hidden">Please enter a valid email address.</p>
          @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <div class="relative">
            <input id="password" type="password" name="password" autocomplete="new-password" required
              class="mt-1 w-full px-4 py-2 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
            <button type="button" onclick="togglePassword('password', this)"
              class="absolute inset-y-0 right-2 flex items-center text-gray-600 hover:text-black">
              <i data-feather="eye"></i>
            </button>
          </div>
          <p id="passwordError" class="text-red-500 text-sm mt-1 hidden">
            Password must be at least 8 characters, include a number and a special character.
          </p>
          @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <div class="relative">
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" required
              class="mt-1 w-full px-4 py-2 bg-gray-50 border border-gray-300 text-gray-900 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none pr-10">
            <button type="button" onclick="togglePassword('password_confirmation', this)"
              class="absolute inset-y-0 right-2 flex items-center text-gray-600 hover:text-black">
              <i data-feather="eye"></i>
            </button>
          </div>
          <p id="confirmError" class="text-red-500 text-sm mt-1 hidden">Passwords do not match.</p>
        </div>

        <!-- Sign Up Button -->
        <button type="submit"
          class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition">
          SIGN UP
        </button>

        <!-- Login Redirect -->
        <p class="mt-6 text-center text-sm text-gray-600">
          Already have an account?
          <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Login</a>
        </p>
      </form>
    </div>
  </section>

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 800, once: true });

    function togglePassword(id, btn) {
      const input = document.getElementById(id);
      const icon = btn.querySelector("i");

      if (input.type === "password") {
        input.type = "text";
        icon.setAttribute("data-feather", "eye-off");
      } else {
        input.type = "password";
        icon.setAttribute("data-feather", "eye");
      }
      feather.replace();
    }

    // Validation + allow submit if valid
    document.getElementById("signupForm").addEventListener("submit", function (e) {
      let valid = true;

      // Email validation
      const email = document.getElementById("email").value;
      const emailError = document.getElementById("emailError");
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
      if (!emailPattern.test(email)) {
        emailError.classList.remove("hidden");
        valid = false;
      } else {
        emailError.classList.add("hidden");
      }

      // Password validation
      const password = document.getElementById("password").value;
      const passwordError = document.getElementById("passwordError");
      const passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/;
      if (!passwordPattern.test(password)) {
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

    feather.replace();
  </script>

</body>
</html>
