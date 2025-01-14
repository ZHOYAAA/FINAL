<div class="bg-white p-5 rounded shadow-lg">
    <h3 class="text-center mb-4 fw-bold">Login</h3>
    <form wire:submit.prevent="login">
        <div class="mb-4">
            <label class="form-label fw-semibold">
                <i class="bi bi-envelope me-2"></i>
                Email Address
            </label>
            <input type="email" 
                wire:model="email" 
                class="form-control form-control-lg bg-light border-0"
                placeholder="name@example.com">
            @error('email') 
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="form-label fw-semibold">
                <i class="bi bi-lock me-2"></i>
                Password
            </label>
            <input type="password" 
                wire:model="password" 
                class="form-control form-control-lg bg-light border-0" 
                placeholder="Enter your password">
            @error('password') 
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <div class="d-grid gap-2 mb-4">
            <button type="submit" class="btn btn-dark btn-lg py-3 fw-bold">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Sign In
            </button>
        </div>

        <div class="text-center">
            <p class="mb-0">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-dark fw-bold text-decoration-none">Register here</a>
            </p>
        </div>
    </form>
</div>