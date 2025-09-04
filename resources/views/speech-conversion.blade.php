<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $pageTitle ?? 'Speech Conversion' }}</title>
    
    <!-- External CSS -->
    <link rel="stylesheet" href="{{ asset('css\speech.conversion.css') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- GSAP for advanced animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
</head>
<body class="font-sans antialiased page-fade-in">
    
    <!-- Circular Back Button -->
    <button id="backButton" class="fixed top-20 left-4 w-10 h-10 bg-gray-800 hover:bg-gray-700 text-white rounded-full shadow-lg z-50 transition-all duration-300 flex items-center justify-center ripple">
        <i class="fas fa-arrow-left"></i>
    </button>
    
    <!-- Toast Notification Container -->
    <div id="toast" class="toast"></div>

    

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-24">
        <div class="text-center mb-12 md:mb-16">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white sm:text-5xl sm:tracking-tight lg:text-6xl animate__animated animate__fadeIn">
                <span class="gradient-text">Speech Conversion</span>
            </h1>
            <p class="mt-3 md:mt-5 max-w-xl mx-auto text-lg md:text-xl text-gray-400 animate__animated animate__fadeIn animate__delay-1s">Convert between text and speech with multi-language support</p>
        </div>

        <div class="max-w-2xl mx-auto">
            <!-- Tabs -->
            <div class="flex mb-6 bg-gray-800 rounded-lg p-1 animate__animated animate__fadeIn animate__delay-1s">
                <button id="ttsTab" class="tab-button flex-1 py-2 px-4 rounded-md font-medium active ripple">
                    <i class="fas fa-volume-up mr-2"></i>Text to Speech
                </button>
                <button id="sttTab" class="tab-button flex-1 py-2 px-4 rounded-md font-medium ripple">
                    <i class="fas fa-microphone mr-2"></i>Speech to Text
                </button>
            </div>

            <!-- Text to Speech Card -->
            <div id="ttsSection" class="card rounded-lg overflow-hidden mb-6 animate__animated animate__fadeIn animate__delay-1s">
                <div class="p-6">
                    <div class="mb-4">
                        <textarea id="ttsText" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-200" rows="5" placeholder="Enter text to convert to speech..."></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <div id="ttsStatus" class="status-text text-blue-400"></div>
                                <div id="ttsProgress" class="progress-bar hidden ml-3" style="width: 100px;">
                                    <div class="progress-fill"></div>
                                </div>
                            </div>
                            <div class="flex">
                                <span id="ttsCharCount" class="character-count mr-3">0 characters</span>
                                <button id="clearTtsText" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-3 py-1 rounded-md text-sm font-medium tooltip ripple">
                                    <i class="fas fa-eraser mr-1"></i>Clear
                                    <span class="tooltiptext">Clear text</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <select id="ttsVoice" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="en-US"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/us.png');"></span> English (US) - Joanna</option>
                            <option value="en-GB"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/gb.png');"></span> English (UK) - Brian</option>
                            <option value="es-ES"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/es.png');"></span> Spanish - Enrique</option>
                            <option value="fr-FR"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/fr.png');"></span> French - Mathieu</option>
                            <option value="de-DE"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/de.png');"></span> German - Hans</option>
                            <option value="it-IT"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/it.png');"></span> Italian - Carla</option>
                            <option value="ja-JP"><span class="language-flag" style="background-image: url('https://flagcdn.com/w20/jp.png');"></span> Japanese - Takumi</option>
                        </select>
                        <div class="voice-preview">
                            <span>Preview voice:</span>
                            <span id="voicePreviewText" class="ml-2">Hello, how are you?</span>
                            <button id="previewVoiceBtn" class="voice-preview-btn ripple">
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

                    <div class="flex flex-wrap justify-center gap-2 mb-4">
                        <button id="playTTS" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple">
                            <i class="fas fa-play mr-2"></i>Play
                            <span class="tooltiptext">Play the text as speech</span>
                        </button>
                        <button id="pauseTTS" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple" disabled>
                            <i class="fas fa-pause mr-2"></i>Pause
                            <span class="tooltiptext">Pause playback</span>
                        </button>
                        <button id="stopTTS" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple" disabled>
                            <i class="fas fa-stop mr-2"></i>Stop
                            <span class="tooltiptext">Stop playback</span>
                        </button>
                        <div class="relative">
                            <button id="speedControlBtn" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple">
                                <i class="fas fa-tachometer-alt mr-2"></i>Speed: 1x
                                <span class="tooltiptext">Adjust playback speed</span>
                            </button>
                            <div id="speedOptions" class="absolute bottom-full left-0 mb-2 w-full bg-gray-800 border border-gray-700 rounded-md shadow-lg hidden z-10">
                                <button class="speed-option w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 ripple" data-speed="0.5">0.5x</button>
                                <button class="speed-option w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 ripple" data-speed="0.75">0.75x</button>
                                <button class="speed-option w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 ripple" data-speed="1" data-selected="true">1x (Normal)</button>
                                <button class="speed-option w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 ripple" data-speed="1.25">1.25x</button>
                                <button class="speed-option w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 ripple" data-speed="1.5">1.5x</button>
                                <button class="speed-option w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 ripple" data-speed="2">2x</button>
                            </div>
                        </div>
                        <button id="downloadTTS" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple">
                            <i class="fas fa-download mr-2"></i>Download
                            <span class="tooltiptext">Download as MP3</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Speech to Text Card -->
            <div id="sttSection" class="card rounded-lg overflow-hidden hidden animate__animated animate__fadeIn">
                <div class="p-6">
                    <!-- Conversation History -->
                    <div id="conversationHistory" class="conversation-history hidden">
                        <!-- Conversation items will be added here dynamically -->
                    </div>

                    <div class="mb-4">
                        <textarea id="sttText" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-gray-200" rows="5" placeholder="Your speech will appear here..."></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <div id="sttStatus" class="status-text text-blue-400"></div>
                            <div class="flex">
                                <span id="sttWordCount" class="character-count mr-3">0 words</span>
                                <button id="clearSttText" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-3 py-1 rounded-md text-sm font-medium tooltip ripple">
                                    <i class="fas fa-eraser mr-1"></i>Clear
                                    <span class="tooltiptext">Clear text</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <select id="sttLanguage" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
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

                    <div class="flex flex-wrap justify-center gap-2 mb-4">
                        <button id="startSTT" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple">
                            <i class="fas fa-microphone mr-2"></i>Start Listening
                            <span class="tooltiptext">Start speech recognition</span>
                        </button>
                        <button id="stopSTT" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip hidden ripple">
                            <i class="fas fa-stop mr-2"></i>Stop
                            <span class="tooltiptext">Stop speech recognition</span>
                        </button>
                        <button id="speakSTT" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple" disabled>
                            <i class="fas fa-volume-up mr-2"></i>Speak
                            <span class="tooltiptext">Speak the recognized text</span>
                        </button>
                        <button id="copySTT" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple" disabled>
                            <i class="fas fa-copy mr-2"></i>Copy
                            <span class="tooltiptext">Copy to clipboard</span>
                        </button>
                        <button id="saveSTT" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple" disabled>
                            <i class="fas fa-save mr-2"></i>Save
                            <span class="tooltiptext">Save as text file</span>
                        </button>
                        <button id="toggleHistory" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm font-medium flex items-center tooltip ripple">
                            <i class="fas fa-history mr-2"></i>History
                            <span class="tooltiptext">Show conversation history</span>
                        </button>
                    </div>
                    <div class="text-center mt-4">
                        <div id="micStatus" class="text-sm text-gray-400 flex items-center justify-center">
                            <span id="micIcon" class="mr-2"><i class="fas fa-microphone-slash"></i></span>
                            <span id="micStatusText">Microphone: Not ready</span>
                        </div>
                        <div id="confidenceMeter" class="mt-2 hidden">
                            <div class="flex justify-between text-xs text-gray-400 mb-1">
                                <span>Confidence:</span>
                                <span id="confidenceValue">0%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div id="confidenceBar" class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

 

    <!-- Dark/Light Mode Toggle -->
    <div class="theme-toggle ripple" id="themeToggle">
        <i class="fas fa-moon text-white" id="themeIcon"></i>
    </div>

    <!-- Microphone Permission Modal -->
    <div id="micModal" class="modal fixed inset-0 bg-gray-900/80 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-gray-800 rounded-lg max-w-md w-full animate__animated animate__fadeInUp">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Microphone Access</h3>
                    <button onclick="closeModal('micModal')" class="text-gray-400 hover:text-white ripple">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4 text-gray-300">
                    <p>To use speech recognition, we need access to your microphone. Your audio is processed locally and never stored or transmitted.</p>
                    <div class="flex justify-end pt-4 space-x-3">
                        <button onclick="closeModal('micModal')" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-md ripple">
                            Cancel
                        </button>
                        <button id="confirmMic" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md ripple">
                            Allow Microphone
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio Context Warning Modal -->
    <div id="audioContextModal" class="modal fixed inset-0 bg-gray-900/80 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-gray-800 rounded-lg max-w-md w-full animate__animated animate__fadeInUp">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Audio Playback Notice</h3>
                    <button onclick="closeModal('audioContextModal')" class="text-gray-400 hover:text-white ripple">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4 text-gray-300">
                    <p>For security reasons, your browser requires interaction with the page before audio can play. Please click the play button again to hear the speech.</p>
                    <div class="flex justify-end pt-4">
                        <button onclick="closeModal('audioContextModal')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md ripple">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversation Options Modal -->
    <div id="conversationModal" class="modal fixed inset-0 bg-gray-900/80 flex items-center justify-center p-4 z-50 opacity-0 invisible">
        <div class="modal-content bg-gray-800 rounded-lg max-w-md w-full animate__animated animate__fadeInUp">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-white">Conversation Options</h3>
                    <button onclick="closeModal('conversationModal')" class="text-gray-400 hover:text-white ripple">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4 text-gray-300">
                    <p>Would you like to start a new conversation or continue with the existing one?</p>
                    <div class="flex flex-col space-y-3 pt-4">
                        <button id="newConversationBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-md font-medium flex items-center justify-center transition-all ripple">
                            <i class="fas fa-plus-circle mr-2"></i> Start New Conversation
                        </button>
                        <button id="continueConversationBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-md font-medium flex items-center justify-center transition-all ripple">
                            <i class="fas fa-play-circle mr-2"></i> Continue Conversation
                        </button>
                        <button onclick="closeModal('conversationModal')" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-3 rounded-md font-medium ripple">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/speech-conversion.js') }}"></script>
</body>
</html>