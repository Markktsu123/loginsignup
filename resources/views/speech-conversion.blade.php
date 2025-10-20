<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Speech Conversion' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    @vite('resources/css/login.css')
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css\speech.conversion.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- GSAP for advanced animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
</head>
<body class="font-sans text-gray-800 bg-gray-50 scroll-smooth">

<img src="{{ asset('images/bg.png') }}" alt="Background" class="background-image opacity-20">
<img src="{{ asset('images/bg.png') }}" alt="Background" class="background-image flipped opacity-20">

<!-- Navbar with Profile Dropdown -->
<nav class="fixed top-0 left-0 w-full backdrop-blur-xl bg-white/50 border-b border-gray-200 shadow-md z-50">
  <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-4">

    <!-- Logo -->
    <a href="{{ route('dashboard') }}" class="text-2xl font-extrabold text-indigo-600 tracking-tight">ASyne</a>

    <!-- Links -->
    <div class="flex items-center space-x-8 relative">
         <a href="{{ route('dashboard') }}" class="text-gray-700 font-medium hover:text-indigo-600 transition">Dashboard</a>
      <a href="{{ route('dashboard') }}#about" class="text-gray-700 font-medium hover:text-indigo-600 transition">About</a>
      <a href="{{ route('dashboard') }}#faqs" class="text-gray-700 font-medium hover:text-indigo-600 transition">FAQ's</a>
      <a href="{{ route('dashboard') }}#contacts" class="text-gray-700 font-medium hover:text-indigo-600 transition">Contacts</a>

      <!-- Profile Dropdown -->
      @auth
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
      @endauth
    </div>
  </div>
</nav>

<!-- Back Button -->
<button id="backButton" class="fixed top-20 left-4 w-10 h-10 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full shadow-lg z-40 transition-all duration-300 flex items-center justify-center">
    <i class="fas fa-arrow-left"></i>
</button>
    
    <!-- Toast Notification Container -->
    <div id="toast" class="toast"></div>

    

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-6 py-28">
        <div class="text-center mb-12 md:mb-16" data-aos="fade-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-indigo-600 mb-4">
                <span class="gradient-text">Speech Conversion</span>
            </h1>
            <p class="text-xl md:text-2xl font-medium text-gray-900 leading-snug italic mb-6">
                'Convert between text and speech with multi-language support.'
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Tabs -->
            <div class="flex mb-8 backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-2 animate__animated animate__fadeIn animate__delay-1s" data-aos="zoom-in">
                <button id="ttsTab" class="tab-button flex-1 py-3 px-6 rounded-2xl font-semibold active ripple transition-all duration-300">
                    <i class="fas fa-volume-up mr-2"></i>Text to Speech
                </button>
                <button id="sttTab" class="tab-button flex-1 py-3 px-6 rounded-2xl font-semibold ripple transition-all duration-300">
                    <i class="fas fa-microphone mr-2"></i>Speech to Text
                </button>
            </div>

            <!-- Text to Speech Card -->
            <div id="ttsSection" class="backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-10 mb-8 hover:scale-[1.02] transition-transform duration-300 animate__animated animate__fadeIn animate__delay-1s" data-aos="zoom-in">
                <div class="space-y-6">
                    <div>
                        <textarea id="ttsText" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-800 placeholder-gray-500" rows="5" placeholder="Enter text to convert to speech..."></textarea>
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center">
                                <div id="ttsStatus" class="status-text text-indigo-600 font-medium"></div>
                                <div id="ttsProgress" class="progress-bar hidden ml-3" style="width: 100px;">
                                    <div class="progress-fill"></div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span id="ttsCharCount" class="text-sm text-gray-600">0 characters</span>
                                <button id="clearTtsText" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-lg text-sm font-medium transition-all duration-200">
                                    <i class="fas fa-eraser mr-1"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <select id="ttsVoice" class="w-full bg-white border border-gray-300 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="en-US"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/us.png');"></span> English (US) - Joanna</option>
                            <option value="en-GB"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/gb.png');"></span> English (UK) - Brian</option>
                            <option value="es-ES"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/es.png');"></span> Spanish - Enrique</option>
                            <option value="fr-FR"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/fr.png');"></span> French - Mathieu</option>
                            <option value="de-DE"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/de.png');"></span> German - Hans</option>
                            <option value="it-IT"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/it.png');"></span> Italian - Carla</option>
                            <option value="ja-JP"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/jp.png');"></span> Japanese - Takumi</option>
                        </select>
                        <div class="flex items-center mt-3 text-sm text-gray-600">
                            <span>Preview voice:</span>
                            <span id="voicePreviewText" class="ml-2 font-medium">Hello, how are you?</span>
                            <button id="previewVoiceBtn" class="ml-3 bg-indigo-100 hover:bg-indigo-200 text-indigo-600 px-3 py-1 rounded-lg transition-all duration-200">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Audio Visualizer (hidden by default) -->
                    <div id="ttsVisualizer" class="visualizer hidden">
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                    </div>

                    <div class="flex flex-wrap justify-center gap-3">
                        <button id="playTTS" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-play mr-2"></i>Play
                        </button>
                        <button id="pauseTTS" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200" disabled>
                            <i class="fas fa-pause mr-2"></i>Pause
                        </button>
                        <button id="stopTTS" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200" disabled>
                            <i class="fas fa-stop mr-2"></i>Stop
                        </button>
                        <div class="relative">
                            <button id="speedControlBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200">
                                <i class="fas fa-tachometer-alt mr-2"></i>Speed: 1x
                            </button>
                            <div id="speedOptions" class="absolute bottom-full left-0 mb-2 w-full bg-white border border-gray-300 rounded-xl shadow-lg hidden z-10">
                                <button class="speed-option w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-all duration-200" data-speed="0.5">0.5x</button>
                                <button class="speed-option w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-all duration-200" data-speed="0.75">0.75x</button>
                                <button class="speed-option w-full text-left px-4 py-3 text-sm text-indigo-600 hover:bg-indigo-50 transition-all duration-200" data-speed="1" data-selected="true">1x (Normal)</button>
                                <button class="speed-option w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-all duration-200" data-speed="1.25">1.25x</button>
                                <button class="speed-option w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-all duration-200" data-speed="1.5">1.5x</button>
                                <button class="speed-option w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-all duration-200" data-speed="2">2x</button>
                            </div>
                        </div>
                        <button id="downloadTTS" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-download mr-2"></i>Download
                        </button>
                    </div>
                </div>
            </div>

            <!-- Speech to Text Card -->
            <div id="sttSection" class="backdrop-blur-2xl bg-white/70 shadow-xl rounded-3xl p-10 mb-8 hover:scale-[1.02] transition-transform duration-300 hidden animate__animated animate__fadeIn" data-aos="zoom-in">
                <div class="space-y-6">
                    <!-- Conversation History -->
                    <div id="conversationHistory" class="conversation-history hidden">
                        <!-- Conversation items will be added here dynamically -->
                    </div>

                    <div>
                        <textarea id="sttText" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-gray-800 placeholder-gray-500" rows="5" placeholder="Your speech will appear here..."></textarea>
                        <div class="flex justify-between items-center mt-3">
                            <div id="sttStatus" class="status-text text-indigo-600 font-medium"></div>
                            <div class="flex items-center space-x-3">
                                <span id="sttWordCount" class="text-sm text-gray-600">0 words</span>
                                <button id="clearSttText" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-1 rounded-lg text-sm font-medium transition-all duration-200">
                                    <i class="fas fa-eraser mr-1"></i>Clear
                                </button>
                            </div>
                        </div>
                    </div>

                    <div>
                        <select id="sttLanguage" class="w-full bg-white border border-gray-300 text-gray-800 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="en-US"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/us.png');"></span> English (US)</option>
                            <option value="en-GB"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/gb.png');"></span> English (UK)</option>
                            <option value="es-ES"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/es.png');"></span> Spanish</option>
                            <option value="fr-FR"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/fr.png');"></span> French</option>
                            <option value="de-DE"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/de.png');"></span> German</option>
                            <option value="it-IT"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/it.png');"></span> Italian</option>
                            <option value="ja-JP"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/jp.png');"></span> Japanese</option>
                        </select>
                    </div>

                    <!-- Audio Visualizer for STT -->
                    <div id="sttVisualizer" class="visualizer hidden">
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                        <div class="visualizer-bar"></div>
                    </div>

                    <div class="flex flex-wrap justify-center gap-3">
                        <button id="startSTT" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-microphone mr-2"></i>Start Listening
                        </button>
                        <button id="stopSTT" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200 hidden">
                            <i class="fas fa-stop mr-2"></i>Stop
                        </button>
                        <button id="speakSTT" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200" disabled>
                            <i class="fas fa-volume-up mr-2"></i>Speak
                        </button>
                        <button id="copySTT" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200" disabled>
                            <i class="fas fa-copy mr-2"></i>Copy
                        </button>
                        <button id="saveSTT" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200" disabled>
                            <i class="fas fa-save mr-2"></i>Save
                        </button>
                        <button id="toggleHistory" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl text-sm font-semibold flex items-center shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-history mr-2"></i>History
                        </button>
                    </div>
                    <div class="text-center mt-6">
                        <div id="micStatus" class="text-sm text-gray-600 flex items-center justify-center">
                            <span id="micIcon" class="mr-2 text-indigo-600"><i class="fas fa-microphone-slash"></i></span>
                            <span id="micStatusText">Microphone: Not ready</span>
                        </div>
                        <div id="confidenceMeter" class="mt-3 hidden">
                            <div class="flex justify-between text-xs text-gray-600 mb-2">
                                <span>Confidence:</span>
                                <span id="confidenceValue">0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="confidenceBar" class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- Microphone Permission Modal -->
    <div id="micModal" class="modal fixed inset-0 bg-gray-900/80 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white rounded-3xl max-w-md w-full animate__animated animate__fadeInUp shadow-2xl">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Microphone Access</h3>
                    <button onclick="closeModal('micModal')" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="space-y-4 text-gray-700">
                    <p class="text-lg">To use speech recognition, we need access to your microphone. Your audio is processed locally and never stored or transmitted.</p>
                    <div class="flex justify-end pt-6 space-x-3">
                        <button onclick="closeModal('micModal')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                            Cancel
                        </button>
                        <button id="confirmMic" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                            Allow Microphone
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Context Warning Modal -->
    <div id="audioContextModal" class="modal fixed inset-0 bg-gray-900/80 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white rounded-3xl max-w-md w-full animate__animated animate__fadeInUp shadow-2xl">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Audio Playback Notice</h3>
                    <button onclick="closeModal('audioContextModal')" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="space-y-4 text-gray-700">
                    <p class="text-lg">For security reasons, your browser requires interaction with the page before audio can play. Please click the play button again to hear the speech.</p>
                    <div class="flex justify-end pt-6">
                        <button onclick="closeModal('audioContextModal')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-200">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversation Options Modal -->
    <div id="conversationModal" class="modal fixed inset-0 bg-gray-900/80 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-white rounded-3xl max-w-md w-full animate__animated animate__fadeInUp shadow-2xl">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Conversation Options</h3>
                    <button onclick="closeModal('conversationModal')" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="space-y-4 text-gray-700">
                    <p class="text-lg">Would you like to start a new conversation or continue with the existing one?</p>
                    <div class="flex flex-col space-y-3 pt-6">
                        <button id="newConversationBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-4 rounded-xl font-semibold flex items-center justify-center transition-all duration-200">
                            <i class="fas fa-plus-circle mr-2"></i> Start New Conversation
                        </button>
                        <button id="continueConversationBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-4 rounded-xl font-semibold flex items-center justify-center transition-all duration-200">
                            <i class="fas fa-play-circle mr-2"></i> Continue Conversation
                        </button>
                        <button onclick="closeModal('conversationModal')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-4 rounded-xl font-semibold transition-all duration-200">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/session-validator.js') }}"></script>
    <script src="{{ asset('js/speech-conversion.js') }}"></script>
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
    </script>
</body>
</html>