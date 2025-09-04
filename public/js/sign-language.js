document.addEventListener('DOMContentLoaded', function() {
    // Back button functionality
    const backButton = document.getElementById('backButton');
    if (backButton) {
        backButton.addEventListener('click', function(e) {
            e.preventDefault();
            // Add fade-out class to body
            document.body.classList.add('page-fade-out');
            
            // Navigate back after animation completes
            setTimeout(function() {
                window.history.back();
            }, 500);
        });
    }

    // Handle permission requests
    const cameraFrame = document.getElementById('cameraFrame');
    const permissionMessage = document.getElementById('permissionMessage');
    const retryButton = document.getElementById('retryButton');

    // Check if camera access was granted
    function checkCameraAccess() {
        if (cameraFrame && cameraFrame.contentWindow) {
            try {
                cameraFrame.contentWindow.postMessage('check_camera_access', '*');
            } catch (e) {
                console.error('Error posting message to iframe:', e);
            }
        }
    }

    // Listen for messages from the iframe
    window.addEventListener('message', function(event) {
        if (event.data === 'camera_denied') {
            if (permissionMessage) {
                permissionMessage.style.display = 'block';
            }
        } else if (event.data === 'camera_granted') {
            if (permissionMessage) {
                permissionMessage.style.display = 'none';
            }
        }
    });

    // Set up retry button
    if (retryButton) {
        retryButton.addEventListener('click', function() {
            if (permissionMessage) {
                permissionMessage.style.display = 'none';
            }
            if (cameraFrame) {
                cameraFrame.src = cameraFrame.src; // Refresh iframe
            }
        });
    }

    // Initial check after iframe loads
    if (cameraFrame) {
        cameraFrame.addEventListener('load', function() {
            setTimeout(checkCameraAccess, 1000); // Wait a second for page to initialize
        });
    }
    
    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.ripple');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const circle = document.createElement('span');
            circle.classList.add('ripple-effect');
            
            const diameter = Math.max(this.clientWidth, this.clientHeight);
            const radius = diameter / 2;
            
            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${e.clientX - this.offsetLeft - radius}px`;
            circle.style.top = `${e.clientY - this.offsetTop - radius}px`;
            
            const ripple = this.getElementsByClassName('ripple-effect')[0];
            if (ripple) {
                ripple.remove();
            }
            
            this.appendChild(circle);
        });
    });
});