@extends('layouts.main')

@section('title', 'Login')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="w-100" style="max-width: 500px;">
            <h2 class="text-center fw-bold text-primary mb-4">Masuk</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <input type="email" name="email" class="form-control form-control-lg"
                        placeholder="Masukkan Email atau Username" required>
                </div>

                <div class="mb-3 position-relative">
                    <input type="password" name="password" id="password" class="form-control form-control-lg"
                        placeholder="Masukkan Kata Sandi" required>
                    <button type="button"
                        class="btn position-absolute end-0 top-50 translate-middle-y me-2 border-0 bg-transparent"
                        onclick="togglePasswordVisibility()">
                        <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                    </button>
                </div>

                @error('email')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror
                <div class="text-end">
                    <a href="{{ route('password.request') }}" class="small text-primary text-decoration-none">Lupa
                        Password?</a>
                </div>

                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-outline-dark btn-lg mt-2">Masuk</button>
                </div>


                <div class="text-center mt-4">
                    <span class="normal">Belum punya akun? <a href="{{ route('register') }}"
                            class="text-primary text-decoration-none">Buat Akun</a></span>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    </script>
@endpush
