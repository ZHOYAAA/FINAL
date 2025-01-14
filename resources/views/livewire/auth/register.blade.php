<div>
    <form wire:submit.prevent="register">
        <!-- Name Input -->
        <div class="mb-3">
            <label class="form-label fw-semibold">
                <i class="bi bi-person me-1"></i>
                Full Name
            </label>
            <input type="text" 
                wire:model="name" 
                class="form-control form-control-lg bg-light" 
                placeholder="Enter your full name">
            @error('name') 
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Email Input -->
        <div class="mb-3">
            <label class="form-label fw-semibold">
                <i class="bi bi-envelope me-1"></i>
                Email Address
            </label>
            <input type="email" 
                wire:model="email" 
                class="form-control form-control-lg bg-light"
                placeholder="name@example.com">
            @error('email') 
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Password Input -->
        <div class="mb-3">
            <label class="form-label fw-semibold">
                <i class="bi bi-lock me-1"></i>
                Password
            </label>
            <input type="password" 
                wire:model="password" 
                class="form-control form-control-lg bg-light"
                placeholder="Create a strong password">
            @error('password') 
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password Input -->
        <div class="mb-4">
            <label class="form-label fw-semibold">
                <i class="bi bi-shield-lock me-1"></i>
                Confirm Password
            </label>
            <input type="password" 
                wire:model="password_confirmation" 
                class="form-control form-control-lg bg-light"
                placeholder="Confirm your password">
        </div>

        <!-- Submit Button -->
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-person-plus me-2"></i>
                Create Account
            </button>
        </div>

        <!-- Optional: Login Link -->
        <div class="text-center mt-3">
            <small class="text-muted">
                Already have an account? 
                <a href="/admin/login" class="text-decoration-none">Login here</a>
            </small>
        </div>
    </form>
</div>