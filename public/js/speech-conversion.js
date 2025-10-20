// Toast notification function
function showToast(message, type = 'info', duration = 3000) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = 'toast'; // Reset classes

    // Add type-specific class
    if (type === 'success') {
        toast.classList.add('bg-green-600');
    } else if (type === 'error') {
        toast.classList.add('bg-red-600');
    } else if (type === 'warning') {
        toast.classList.add('bg-yellow-600');
    } else {
        toast.classList.add('bg-gray-800');
    }

    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, duration);
}

// Modal functions
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Close modals when clicking outside content
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});

// Theme toggle functionality removed - using light theme by default

// Back button functionality with fade animation
document.getElementById('backButton').addEventListener('click', function(e) {
    e.preventDefault();

    // Add fade-out class to body
    document.body.classList.add('page-fade-out');

    // Wait for animation to complete before redirecting
    setTimeout(function() {
        window.location.href = '/dashboard';
    }, 500);
});

// Initialize GSAP animations
gsap.from('main', {duration: 0.5, opacity: 0, y: 20, ease: "power2.out"});

// Add ripple effect to all buttons
document.querySelectorAll('.ripple').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const x = e.clientX - e.target.getBoundingClientRect().left;
        const y = e.clientY - e.target.getBoundingClientRect().top;

        const ripple = document.createElement('span');
        ripple.className = 'ripple-effect';
        ripple.style.left = `${x}px`;
        ripple.style.top = `${y}px`;

        this.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 1000);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // This will make the page fade in when loaded
    document.body.classList.add('page-fade-in');

    // Tab switching with animation
    const ttsTab = document.getElementById('ttsTab');
    const sttTab = document.getElementById('sttTab');
    const ttsSection = document.getElementById('ttsSection');
    const sttSection = document.getElementById('sttSection');

    function switchTab(toTts) {
        if (toTts) {
            // Animate out STT section
            gsap.to(sttSection, {
                duration: 0.3,
                opacity: 0,
                y: 20,
                ease: "power2.in",
                onComplete: () => {
                    sttSection.classList.add('hidden');
                    ttsSection.classList.remove('hidden');
                    // Animate in TTS section
                    gsap.fromTo(ttsSection,
                        {opacity: 0, y: -20},
                        {duration: 0.3, opacity: 1, y: 0, ease: "power2.out"}
                    );
                }
            });

            ttsTab.classList.add('active');
            sttTab.classList.remove('active');

            // Stop any ongoing STT when switching tabs
            if (window.recognition && window.isListening) {
                stopSTT();
            }
        } else {
            // Animate out TTS section
            gsap.to(ttsSection, {
                duration: 0.3,
                opacity: 0,
                y: 20,
                ease: "power2.in",
                onComplete: () => {
                    ttsSection.classList.add('hidden');
                    sttSection.classList.remove('hidden');
                    // Animate in STT section
                    gsap.fromTo(sttSection,
                        {opacity: 0, y: -20},
                        {duration: 0.3, opacity: 1, y: 0, ease: "power2.out"}
                    );
                }
            });

            sttTab.classList.add('active');
            ttsTab.classList.remove('active');

            // Stop any ongoing TTS when switching tabs
            if (window.speechSynthesis && window.speechSynthesis.speaking) {
                window.speechSynthesis.cancel();
                resetTTSButtons();
            }
        }
    }

    ttsTab.addEventListener('click', () => switchTab(true));
    sttTab.addEventListener('click', () => switchTab(false));

    // Text to Speech functionality
    const ttsText = document.getElementById('ttsText');
    const ttsVoice = document.getElementById('ttsVoice');
    const playTTSBtn = document.getElementById('playTTS');
    const pauseTTSBtn = document.getElementById('pauseTTS');
    const stopTTSBtn = document.getElementById('stopTTS');
    const clearTtsTextBtn = document.getElementById('clearTtsText');
    const ttsStatus = document.getElementById('ttsStatus');
    const ttsCharCount = document.getElementById('ttsCharCount');
    const ttsProgress = document.getElementById('ttsProgress');
    const progressFill = ttsProgress.querySelector('.progress-fill');
    const speedControlBtn = document.getElementById('speedControlBtn');
    const speedOptions = document.getElementById('speedOptions');
    const previewVoiceBtn = document.getElementById('previewVoiceBtn');
    const voicePreviewText = document.getElementById('voicePreviewText');
    const downloadTTSBtn = document.getElementById('downloadTTS');
    const ttsVisualizer = document.getElementById('ttsVisualizer');
    const visualizerBars = ttsVisualizer.querySelectorAll('.visualizer-bar');

    // Current playback rate
    let playbackRate = 1;
    let audioContext;
    let analyser;
    let dataArray;
    let animationId;

    // Initialize audio context for visualizer
    function initAudioContext() {
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        analyser = audioContext.createAnalyser();
        analyser.fftSize = 32;
        const bufferLength = analyser.frequencyBinCount;
        dataArray = new Uint8Array(bufferLength);
    }

    // Enhanced Animate visualizer
    function animateVisualizer() {
        if (!analyser) return;

        analyser.getByteFrequencyData(dataArray);

        for (let i = 0; i < visualizerBars.length; i++) {
            const value = dataArray[i] / 255;
            const height = value * 100;
            gsap.to(visualizerBars[i], {
                duration: 0.1,
                scaleY: height || 0.1,
                ease: "power1.out"
            });
        }

        animationId = requestAnimationFrame(animateVisualizer);
    }

    // Stop visualizer animation
    function stopVisualizer() {
        if (animationId) {
            cancelAnimationFrame(animationId);
            animationId = null;
        }

        visualizerBars.forEach(bar => {
            gsap.to(bar, {
                duration: 0.3,
                scaleY: 0.1,
                ease: "power1.out"
            });
        });
    }

    // Speed control functionality
    speedControlBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        speedOptions.classList.toggle('hidden');
    });

    document.querySelectorAll('.speed-option').forEach(option => {
        option.addEventListener('click', function() {
            playbackRate = parseFloat(this.dataset.speed);
            speedControlBtn.innerHTML = `<i class="fas fa-tachometer-alt mr-2"></i>Speed: ${playbackRate}x`;

            // Update selected state
            document.querySelectorAll('.speed-option').forEach(opt => {
                opt.removeAttribute('data-selected');
            });
            this.setAttribute('data-selected', 'true');

            speedOptions.classList.add('hidden');

            // Update current utterance if playing
            if (window.speechSynthesis.speaking) {
                window.speechSynthesis.cancel();
                playTTS();
            }
        });
    });

    // Close speed options when clicking elsewhere
    document.addEventListener('click', function(e) {
        if (!speedControlBtn.contains(e.target)) {
            speedOptions.classList.add('hidden');
        }
    });

    // Character count update
    ttsText.addEventListener('input', function() {
        const count = this.value.length;
        ttsCharCount.textContent = `${count} characters`;
    });

    // Voice preview functionality
    previewVoiceBtn.addEventListener('click', function() {
        const previewText = voicePreviewText.textContent;
        const utterance = new SpeechSynthesisUtterance(previewText);
        utterance.lang = ttsVoice.value;
        utterance.rate = playbackRate;

        // Get available voices and set the selected one
        function speakPreview() {
            const voices = window.speechSynthesis.getVoices();
            const selectedVoice = voices.find(voice => voice.lang === ttsVoice.value);
            if (selectedVoice) {
                utterance.voice = selectedVoice;
            }
            window.speechSynthesis.speak(utterance);
        }

        // If voices are already loaded
        const voices = window.speechSynthesis.getVoices();
        if (voices.length > 0) {
            speakPreview();
        } else {
            // Wait for voices to load
            speechSynthesis.onvoiceschanged = speakPreview;
        }
    });

    // Clear text button functionality
    clearTtsTextBtn.addEventListener('click', function() {
        ttsText.value = '';
        ttsCharCount.textContent = '0 characters';
        showToast("Text cleared", "success");
    });

    // TTS Playback functions
    function resetTTSButtons() {
        playTTSBtn.disabled = false;
        pauseTTSBtn.disabled = true;
        stopTTSBtn.disabled = true;
        ttsStatus.textContent = "";
        ttsProgress.classList.add('hidden');
        ttsVisualizer.classList.add('hidden');
        stopVisualizer();
    }

    function updateProgress(event) {
        if (event.utterance && event.charIndex) {
            const progress = (event.charIndex / event.utterance.text.length) * 100;
            progressFill.style.width = `${progress}%`;
        }
    }

    function playTTS() {
        if (ttsText.value.trim() === '') {
            showToast("Please enter some text first", "warning");
            return;
        }

        // Cancel any current speech
        window.speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(ttsText.value);
        utterance.lang = ttsVoice.value;
        utterance.rate = playbackRate;
        ttsStatus.textContent = "Playing...";
        ttsProgress.classList.remove('hidden');
        progressFill.style.width = '0%';

        // Show visualizer
        ttsVisualizer.classList.remove('hidden');
        if (!audioContext) initAudioContext();
        animateVisualizer();

        utterance.onboundary = updateProgress;

        utterance.onend = function() {
            resetTTSButtons();
            showToast("Playback complete", "success");
        };

        utterance.onerror = function(event) {
            resetTTSButtons();
            showToast("Error: " + event.error, "error");
        };

        // Get available voices and set the selected one
        function speakWithVoice() {
            const voices = window.speechSynthesis.getVoices();
            const selectedVoice = voices.find(voice => voice.lang === ttsVoice.value);
            if (selectedVoice) {
                utterance.voice = selectedVoice;
            }

            try {
                window.speechSynthesis.speak(utterance);
            } catch (e) {
                // Handle audio context issues in Chrome
                if (e.name === 'NotAllowedError') {
                    openModal('audioContextModal');
                } else {
                    showToast("Error: " + e.message, "error");
                }
                resetTTSButtons();
                return;
            }
        }

        // If voices are already loaded
        const voices = window.speechSynthesis.getVoices();
        if (voices.length > 0) {
            speakWithVoice();
        } else {
            // Wait for voices to load
            speechSynthesis.onvoiceschanged = speakWithVoice;
        }

        playTTSBtn.disabled = true;
        pauseTTSBtn.disabled = false;
        stopTTSBtn.disabled = false;
    }

    playTTSBtn.addEventListener('click', playTTS);

    pauseTTSBtn.addEventListener('click', function() {
        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.pause();
            pauseTTSBtn.disabled = true;
            playTTSBtn.disabled = false;
            ttsStatus.textContent = "Paused";
            stopVisualizer();
        }
    });

    stopTTSBtn.addEventListener('click', function() {
        window.speechSynthesis.cancel();
        resetTTSButtons();
        showToast("Playback stopped", "info");
    });

    // Download TTS as MP3 (simulated - would need server-side implementation)
    downloadTTSBtn.addEventListener('click', function() {
        if (ttsText.value.trim() === '') {
            showToast("Please enter some text first", "warning");
            return;
        }

        showToast("This feature would require server-side implementation", "info");
        // In a real implementation, you would send the text to a server
        // that converts it to MP3 and returns a download link
    });

    // Check if speech synthesis is supported
    if (!('speechSynthesis' in window)) {
        playTTSBtn.disabled = true;
        pauseTTSBtn.disabled = true;
        stopTTSBtn.disabled = true;
        previewVoiceBtn.disabled = true;
        downloadTTSBtn.disabled = true;
        ttsText.placeholder = "Text-to-speech not supported in your browser";
        showToast("Text-to-speech not supported in your browser", "error");
    }

    // Speech to Text functionality
    const sttText = document.getElementById('sttText');
    const sttLanguage = document.getElementById('sttLanguage');
    const startSTTBtn = document.getElementById('startSTT');
    const stopSTTBtn = document.getElementById('stopSTT');
    const speakSTTBtn = document.getElementById('speakSTT');
    const clearSttTextBtn = document.getElementById('clearSttText');
    const sttStatus = document.getElementById('sttStatus');
    const micIcon = document.getElementById('micIcon');
    const micStatusText = document.getElementById('micStatusText');
    const sttWordCount = document.getElementById('sttWordCount');
    const copySTTBtn = document.getElementById('copySTT');
    const saveSTTBtn = document.getElementById('saveSTT');
    const confidenceMeter = document.getElementById('confidenceMeter');
    const confidenceBar = document.getElementById('confidenceBar');
    const confidenceValue = document.getElementById('confidenceValue');
    const toggleHistoryBtn = document.getElementById('toggleHistory');
    const conversationHistory = document.getElementById('conversationHistory');
    const sttVisualizer = document.getElementById('sttVisualizer');
    const sttVisualizerBars = sttVisualizer.querySelectorAll('.visualizer-bar');
    let sttAnimationId;

    // Variables for speech recognition
    let recognition;
    let isListening = false;
    let finalTranscript = '';
    let conversation = [];
    let mediaStream;

    // Animate STT visualizer
    function animateSTTVisualizer() {
        if (!mediaStream) return;

        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const analyser = audioContext.createAnalyser();
        analyser.fftSize = 32;
        const bufferLength = analyser.frequencyBinCount;
        const dataArray = new Uint8Array(bufferLength);

        const source = audioContext.createMediaStreamSource(mediaStream);
        source.connect(analyser);

        function update() {
            analyser.getByteFrequencyData(dataArray);

            for (let i = 0; i < sttVisualizerBars.length; i++) {
                const value = dataArray[i] / 255;
                const height = value * 100;
                gsap.to(sttVisualizerBars[i], {
                    duration: 0.1,
                    scaleY: height || 0.1,
                    ease: "power1.out"
                });
            }

            sttAnimationId = requestAnimationFrame(update);
        }

        update();
    }

    // Stop STT visualizer
    function stopSTTVisualizer() {
        if (sttAnimationId) {
            cancelAnimationFrame(sttAnimationId);
            sttAnimationId = null;
        }

        sttVisualizerBars.forEach(bar => {
            gsap.to(bar, {
                duration: 0.3,
                scaleY: 0.1,
                ease: "power1.out"
            });
        });
    }

    // Enhanced transcript cleaning function
    function cleanTranscript(transcript) {
        // Remove any HTML tags that might have been interpreted
        let cleaned = transcript.replace(/<\/?[^>]+(>|$)/g, '');

        // Remove special code-like characters that sometimes appear
        cleaned = cleaned.replace(/[{}<>]/g, '');

        // Fix common misinterpretations
        cleaned = cleaned.replace(/&lt;/g, '<')
                        .replace(/&gt;/g, '>')
                        .replace(/&amp;/g, '&')
                        .replace(/&quot;/g, '"')
                        .replace(/&apos;/g, "'");

        // Normalize whitespace
        cleaned = cleaned.replace(/\s+/g, ' ').trim();

        return cleaned;
    }

    // Add to conversation history
    function addToConversation(text, type) {
        const now = new Date();
        const timeString = now.toLocaleTimeString();

        conversation.push({
            text,
            type,
            time: timeString
        });

        updateConversationUI();
    }

    // Update conversation history UI
    function updateConversationUI() {
        conversationHistory.innerHTML = '';

        conversation.forEach(item => {
            const div = document.createElement('div');
            div.className = `conversation-item ${item.type}`;
            div.innerHTML = `
                <div>${item.text}</div>
                <div class="conversation-time">${item.time}</div>
            `;
            conversationHistory.appendChild(div);
        });

        // Scroll to bottom
        conversationHistory.scrollTop = conversationHistory.scrollHeight;
    }

    // Toggle conversation history visibility
    toggleHistoryBtn.addEventListener('click', function() {
        conversationHistory.classList.toggle('hidden');
        if (conversationHistory.classList.contains('hidden')) {
            toggleHistoryBtn.innerHTML = '<i class="fas fa-history mr-2"></i>History';
            showToast("Conversation history hidden", "info");
        } else {
            toggleHistoryBtn.innerHTML = '<i class="fas fa-eye-slash mr-2"></i>Hide';
            showToast("Conversation history shown", "info");
        }
    });

    // Word count update
    function updateWordCount() {
        const text = sttText.value.replace(/<[^>]*>?/gm, ''); // Remove HTML tags
        const wordCount = text.trim() === '' ? 0 : text.trim().split(/\s+/).length;
        sttWordCount.textContent = `${wordCount} words`;

        // Enable/disable buttons based on content
        const hasContent = text.trim() !== '';
        speakSTTBtn.disabled = !hasContent;
        copySTTBtn.disabled = !hasContent;
        saveSTTBtn.disabled = !hasContent;
    }

    sttText.addEventListener('input', updateWordCount);

    // Clear text button functionality
    clearSttTextBtn.addEventListener('click', function() {
        sttText.value = '';
        finalTranscript = '';
        updateWordCount();
        showToast("Text cleared", "success");
        confidenceMeter.classList.add('hidden');
    });

    // Copy text to clipboard
    copySTTBtn.addEventListener('click', function() {
        const text = sttText.value.replace(/<[^>]*>?/gm, ''); // Remove HTML tags
        navigator.clipboard.writeText(text).then(() => {
            showToast("Text copied to clipboard", "success");
        }).catch(err => {
            showToast("Failed to copy text", "error");
        });
    });

    // Save text to file
    saveSTTBtn.addEventListener('click', function() {
        const text = sttText.value.replace(/<[^>]*>?/gm, ''); // Remove HTML tags
        const blob = new Blob([text], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'speech-to-text.txt';
        a.click();
        URL.revokeObjectURL(url);

        showToast("Text saved as file", "success");
    });

    // Initialize speech recognition with enhanced transcript handling
    function initSpeechRecognition() {
        // Check for browser support
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (SpeechRecognition) {
            recognition = new SpeechRecognition();
            recognition.continuous = true;
            recognition.interimResults = true;
            recognition.lang = sttLanguage.value;

            recognition.onstart = function() {
                isListening = true;
                startSTTBtn.classList.add('hidden');
                stopSTTBtn.classList.remove('hidden');
                startSTTBtn.classList.add('recording', 'wave-animation');
                sttStatus.textContent = "Listening...";
                updateMicStatus(true);
                sttVisualizer.classList.remove('hidden');
                animateSTTVisualizer();
            };

            recognition.onresult = function(event) {
                let interimTranscript = '';
                let newFinalTranscript = '';

                for (let i = event.resultIndex; i < event.results.length; i++) {
                    const result = event.results[i];
                    let transcript = result[0].transcript;

                    // Clean the transcript before processing
                    transcript = cleanTranscript(transcript);

                    if (result.isFinal) {
                        newFinalTranscript += transcript + ' ';
                        finalTranscript += transcript + ' ';

                        // Show confidence level for final results
                        if (result[0].confidence) {
                            const confidence = Math.round(result[0].confidence * 100);
                            confidenceBar.style.width = `${confidence}%`;
                            confidenceValue.textContent = `${confidence}%`;
                            confidenceMeter.classList.remove('hidden');
                        }

                        // Add to conversation history
                        addToConversation(transcript, 'sent');
                    } else {
                        interimTranscript += transcript;
                    }
                }

                // Update the textarea with cleaned transcripts
                if (newFinalTranscript) {
                    sttText.value = finalTranscript;
                } else {
                    // Only show interim results if no new final results
                    sttText.value = finalTranscript + interimTranscript;
                }

                updateWordCount();
            };

            recognition.onerror = function(event) {
                console.error('Speech recognition error', event.error);
                stopSTT();
                showToast("Error: " + event.error, "error");

                if (event.error === 'not-allowed') {
                    openModal('micModal');
                    updateMicStatus(false);
                }
            };

            recognition.onend = function() {
                if (isListening) {
                    recognition.start();
                } else {
                    startSTTBtn.classList.remove('hidden', 'recording', 'wave-animation');
                    stopSTTBtn.classList.add('hidden');
                    sttStatus.textContent = "Ready";
                    updateMicStatus(false);
                    sttVisualizer.classList.add('hidden');
                    stopSTTVisualizer();

                    // Release microphone
                    if (mediaStream) {
                        mediaStream.getTracks().forEach(track => track.stop());
                        mediaStream = null;
                    }
                }
            };
        } else {
            startSTTBtn.disabled = true;
            sttText.placeholder = "Speech recognition not supported in your browser";
            showToast("Speech recognition not supported", "error");
            updateMicStatus(false, "Not supported");
        }
    }

    // Update microphone status indicator
    function updateMicStatus(active, customMessage = null) {
        if (customMessage) {
            micStatusText.textContent = "Microphone: " + customMessage;
            micIcon.innerHTML = '<i class="fas fa-microphone-slash"></i>';
            return;
        }

        if (active) {
            micStatusText.textContent = "Microphone: Active";
            micIcon.innerHTML = '<i class="fas fa-microphone blink" style="color:#3B82F6"></i>';
        } else {
            micStatusText.textContent = "Microphone: Inactive";
            micIcon.innerHTML = '<i class="fas fa-microphone-slash"></i>';
        }
    }

    // Start speech recognition with permission handling
    function startSTT() {
        if (!recognition) {
            initSpeechRecognition();
        }

        if (!isListening) {
            openModal('conversationModal');
        }
    }

    // Add event listeners for the new conversation buttons
    document.getElementById('newConversationBtn').addEventListener('click', function() {
        closeModal('conversationModal');
        sttText.value = '';
        finalTranscript = '';
        conversation = [];
        conversationHistory.innerHTML = '';
        updateWordCount();
        startListening();
    });

    document.getElementById('continueConversationBtn').addEventListener('click', function() {
        closeModal('conversationModal');
        startListening();
    });

    // Extract the actual listening start to a separate function
    function startListening() {
        try {
            // First check microphone permission
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(function(stream) {
                    // Permission granted
                    mediaStream = stream;
                    updateMicStatus(true);
                    recognition.lang = sttLanguage.value;
                    recognition.start();
                })
                .catch(function(err) {
                    console.error('Microphone access error:', err);
                    openModal('micModal');
                    updateMicStatus(false);
                });
        } catch (e) {
            console.error("Recognition start error:", e);
            showToast("Error starting recognition", "error");
            openModal('micModal');
        }
    }

    // Stop speech recognition
    function stopSTT() {
        if (recognition && isListening) {
            isListening = false;
            recognition.stop();
        }
    }

    // Speak the recognized text
    function speakSTT() {
        const text = sttText.value.replace(/<[^>]*>?/gm, '').trim();
        if (text !== '') {
            // Cancel any current speech
            window.speechSynthesis.cancel();

            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = sttLanguage.value;
            utterance.rate = playbackRate;
            sttStatus.textContent = "Speaking...";
            speakSTTBtn.disabled = true;

            // Add to conversation history
            addToConversation(text, 'received');

            utterance.onend = function() {
                sttStatus.textContent = "Speech complete";
                speakSTTBtn.disabled = false;
                showToast("Speech complete", "success");
            };

            utterance.onerror = function(event) {
                sttStatus.textContent = "Error: " + event.error;
                speakSTTBtn.disabled = false;
                showToast("Error: " + event.error, "error");
            };

            // Get available voices and set the selected one
            function speakWithVoice() {
                const voices = window.speechSynthesis.getVoices();
                const selectedVoice = voices.find(voice => voice.lang === sttLanguage.value);
                if (selectedVoice) {
                    utterance.voice = selectedVoice;
                }
                window.speechSynthesis.speak(utterance);
            }

            // If voices are already loaded
            const voices = window.speechSynthesis.getVoices();
            if (voices.length > 0) {
                speakWithVoice();
            } else {
                // Wait for voices to load
                speechSynthesis.onvoiceschanged = speakWithVoice;
            }
        }
    }

    // Event listeners for STT
    startSTTBtn.addEventListener('click', startSTT);
    stopSTTBtn.addEventListener('click', stopSTT);
    speakSTTBtn.addEventListener('click', speakSTT);

    // Language change handler
    sttLanguage.addEventListener('change', function() {
        if (recognition) {
            recognition.lang = sttLanguage.value;
            showToast("Language changed to " + sttLanguage.options[sttLanguage.selectedIndex].text, "info");
        }
    });

    // Microphone permission modal
    document.getElementById('confirmMic').addEventListener('click', function() {
        closeModal('micModal');
        // Try to start recognition after permission is granted
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function(stream) {
                console.log("Microphone access granted");
                mediaStream = stream;
                updateMicStatus(true);
                startSTT();
            })
            .catch(function(err) {
                console.error("Microphone access denied:", err);
                updateMicStatus(false, "Access denied");
                showToast("Microphone access denied", "error");
            });
    });

    // Initial microphone status check
    function checkMicrophonePermission() {
        if (navigator.permissions) {
            navigator.permissions.query({name: 'microphone'}).then(permissionStatus => {
                if (permissionStatus.state === 'granted') {
                    updateMicStatus(false, "Ready (access granted)");
                } else {
                    updateMicStatus(false, "Click Start to request access");
                }
            }).catch(error => {
                console.error('Permission query error:', error);
                updateMicStatus(false, "Click Start to check access");
            });
        } else {
            updateMicStatus(false, "Click Start to check access");
        }
    }

    // Check if speech recognition is supported
    if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
        startSTTBtn.disabled = true;
        sttText.placeholder = "Speech recognition not supported in your browser";
        showToast("Speech recognition not supported", "error");
        updateMicStatus(false, "Not supported");
    } else {
        checkMicrophonePermission();
    }

    // Initialize word count
    updateWordCount();
});