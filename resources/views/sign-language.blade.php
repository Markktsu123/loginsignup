<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sign-language.css') }}">
   
    
    <title>Sign Language Detection</title>
</head>
<body class="font-sans bg-gray-900">  
    <button id="backButton" class="back-button">
        <i class="fas fa-arrow-left"></i>
    </button>
   
    <br><br>
  
    <div class="text-center mb-12 md:mb-16">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white sm:text-5xl sm:tracking-tight lg:text-6xl animate-fade-in">
            <span class="gradient-text">Sign Language Detection </span>
        </h1>
        <p class="mt-3 md:mt-5 max-w-xl mx-auto text-lg md:text-xl text-gray-400 animate-fade-in-delay">
            Convert Action/Greeting Gestures into Text
        </p>
    </div>

    <!-- Permission Message -->
    <div id="permissionMessage" class="permission-message">
        <p>Please allow camera access for sign language detection.</p>
        <button id="retryButton" class="retry-button">Retry</button>
    </div>

    <!-- Flask Content Embedded Here -->
    <div class="flask-container-wrapper">
        <iframe 
            src="https://192.168.1.10:5000" 
            class="flask-container"
            allow="camera"
            id="cameraFrame"></iframe>
    </div>
    
    <script src="{{ asset('js/sign-language.js') }}"></script>
</body>
</html>