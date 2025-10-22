/**
 * Session Validator - Prevents unauthorized access via browser back button
 * and ensures session validity across all protected pages
 */

class SessionValidator {
    constructor() {
        this.checkInterval = 30000; // Check every 30 seconds
        this.sessionCheckUrl = '/api/session/validate';
        this.logoutUrl = '/api/session/logout';
        this.loginUrl = '/login';
        this.intervalId = null;
        this.isChecking = false;
        this.lastActivity = Date.now();
        this.activityTimeout = 300000; // 5 minutes of inactivity
        this.isLoggedIn = false;
        
        this.init();
    }

    init() {
        // Only run on protected pages (not login/register pages)
        if (this.isProtectedPage()) {
            this.startSessionMonitoring();
            this.setupActivityTracking();
            this.setupPageVisibilityHandling();
            this.preventBrowserBackButton();
        }
    }

    isProtectedPage() {
        const currentPath = window.location.pathname;
        const publicPages = ['/login', '/register', '/'];
        return !publicPages.includes(currentPath);
    }

    startSessionMonitoring() {
        // Initial check
        this.validateSession();
        
        // Set up interval checking
        this.intervalId = setInterval(() => {
            this.validateSession();
        }, this.checkInterval);
    }

    async validateSession() {
        if (this.isChecking) return;
        
        this.isChecking = true;
        
        try {
            const response = await fetch(this.sessionCheckUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.session_valid) {
                    this.isLoggedIn = true;
                    this.updateLastActivity();
                } else {
                    this.handleSessionInvalid();
                }
            } else {
                // Session invalid or expired
                this.handleSessionInvalid();
            }
        } catch (error) {
            console.error('Session validation error:', error);
            // On network error, check if we're still on a protected page
            if (this.isProtectedPage()) {
                this.handleSessionInvalid();
            }
        } finally {
            this.isChecking = false;
        }
    }

    handleSessionInvalid() {
        this.stopSessionMonitoring();
        this.showSessionExpiredMessage();
        
        // Clear any cached data
        this.clearCache();
        
        // Redirect to login after a short delay
        setTimeout(() => {
            window.location.href = this.loginUrl + '?session_expired=1';
        }, 2000);
    }

    showSessionExpiredMessage() {
        // Remove any existing messages
        const existingMessage = document.getElementById('session-expired-message');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create and show message
        const messageDiv = document.createElement('div');
        messageDiv.id = 'session-expired-message';
        messageDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]';
        messageDiv.innerHTML = `
            <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Session Expired</h3>
                <p class="text-gray-600 text-base mb-6">Your session has expired for security reasons. You will be redirected to the login page.</p>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-blue-800 font-medium">Redirecting...</span>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(messageDiv);
    }

    setupActivityTracking() {
        // Track user activity
        const activityEvents = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
        
        activityEvents.forEach(event => {
            document.addEventListener(event, () => {
                this.updateLastActivity();
            }, true);
        });

        // Check for inactivity
        setInterval(() => {
            if (this.isProtectedPage() && this.isLoggedIn) {
                const timeSinceActivity = Date.now() - this.lastActivity;
                if (timeSinceActivity > this.activityTimeout) {
                    this.handleInactivity();
                }
            }
        }, 60000); // Check every minute
    }

    handleInactivity() {
        console.log('User inactive, validating session...');
        this.validateSession();
    }

    updateLastActivity() {
        this.lastActivity = Date.now();
    }

    setupPageVisibilityHandling() {
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible' && this.isProtectedPage()) {
                // Page became visible, validate session
                this.validateSession();
            }
        });

        // Handle page focus
        window.addEventListener('focus', () => {
            if (this.isProtectedPage()) {
                this.validateSession();
            }
        });
    }

    preventBrowserBackButton() {
        // Disable browser back button on protected pages
        window.addEventListener('popstate', (event) => {
            if (this.isProtectedPage()) {
                // Validate session when user tries to go back
                this.validateSession();
                
                // Push current state back to prevent navigation
                history.pushState(null, null, window.location.href);
                
                // Show warning message
                this.showBackButtonWarning();
            }
        });

        // Push initial state
        if (this.isProtectedPage()) {
            history.pushState(null, null, window.location.href);
        }
    }

    showBackButtonWarning() {
        // Remove any existing messages
        const existingMessage = document.getElementById('back-button-warning');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create and show warning message
        const messageDiv = document.createElement('div');
        messageDiv.id = 'back-button-warning';
        messageDiv.className = 'fixed top-4 right-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg shadow-lg z-[9999] max-w-sm';
        messageDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <span class="font-medium">Please use navigation buttons instead of browser back button for security.</span>
            </div>
        `;
        
        document.body.appendChild(messageDiv);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.remove();
            }
        }, 5000);
    }

    clearCache() {
        // Clear any cached data that might contain sensitive information
        if ('caches' in window) {
            caches.keys().then(names => {
                names.forEach(name => {
                    caches.delete(name);
                });
            });
        }
        
        // Clear localStorage of sensitive data
        const sensitiveKeys = ['user_data', 'session_data', 'auth_token'];
        sensitiveKeys.forEach(key => {
            localStorage.removeItem(key);
        });
    }

    stopSessionMonitoring() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
    }

    // Public method to force logout
    async forceLogout() {
        try {
            await fetch(this.logoutUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            });
        } catch (error) {
            console.error('Force logout error:', error);
        } finally {
            this.handleSessionInvalid();
        }
    }
}

// Initialize session validator when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.sessionValidator = new SessionValidator();
});

// Also initialize if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        window.sessionValidator = new SessionValidator();
    });
} else {
    window.sessionValidator = new SessionValidator();
}

// Export for manual initialization if needed
window.SessionValidator = SessionValidator;

