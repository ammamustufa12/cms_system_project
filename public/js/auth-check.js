/**
 * Authentication Check Helper
 * This script helps check if user is logged in and redirects if not
 */

class AuthChecker {
    constructor() {
        this.checkInterval = null;
        this.isChecking = false;
    }

    /**
     * Check if user is authenticated
     */
    async checkAuth() {
        if (this.isChecking) return;
        
        this.isChecking = true;
        
        try {
            const response = await fetch('/check-auth', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (!data.authenticated) {
                this.redirectToLogin();
            }
            
            return data.authenticated;
        } catch (error) {
            console.error('Auth check failed:', error);
            this.redirectToLogin();
            return false;
        } finally {
            this.isChecking = false;
        }
    }

    /**
     * Redirect to login page
     */
    redirectToLogin() {
        window.location.href = '/admin/login';
    }

    /**
     * Start periodic authentication check
     */
    startPeriodicCheck(interval = 30000) { // Check every 30 seconds
        this.checkInterval = setInterval(() => {
            this.checkAuth();
        }, interval);
    }

    /**
     * Stop periodic authentication check
     */
    stopPeriodicCheck() {
        if (this.checkInterval) {
            clearInterval(this.checkInterval);
            this.checkInterval = null;
        }
    }

    /**
     * Protect a page - check auth and redirect if not logged in
     */
    async protectPage() {
        const isAuthenticated = await this.checkAuth();
        if (!isAuthenticated) {
            return false;
        }
        return true;
    }
}

// Create global instance
window.authChecker = new AuthChecker();

// Auto-protect pages that require authentication
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a protected page
    if (window.location.pathname.startsWith('/admin/')) {
        window.authChecker.protectPage();
    }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AuthChecker;
}

