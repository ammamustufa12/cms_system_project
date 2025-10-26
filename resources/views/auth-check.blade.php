{{-- Authentication Check Template --}}
@if(!Auth::guard('twill_users')->check())
    <script>
        // Redirect to login if not authenticated
        window.location.href = '{{ route("twill.login") }}';
    </script>
    <div class="auth-redirect">
        <div class="text-center">
            <h3>Redirecting to login...</h3>
            <p>Please wait while we redirect you to the login page.</p>
        </div>
    </div>
@else
    {{-- User is authenticated, show content --}}
    @yield('content')
@endif

<style>
.auth-redirect {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f8f9fa;
}

.auth-redirect h3 {
    color: #6c757d;
    margin-bottom: 1rem;
}

.auth-redirect p {
    color: #6c757d;
}
</style>

