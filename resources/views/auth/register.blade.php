@extends('layouts.main')

@section('title', 'Register')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 60vh;">
        <div class="w-100" style="max-width: 500px;">
            <h2 class="text-center fw-bold text-primary mb-4">Daftar</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <input type="text" name="name" class="form-control form-control-lg"
                        placeholder="Masukkan Nama Lengkap" required>
                </div>

                <div class="mb-3">
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Masukkan Email"
                        required>
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

                <div class="mb-3 position-relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control form-control-lg" placeholder="Konfirmasi Kata Sandi" required>
                    <button type="button"
                        class="btn position-absolute end-0 top-50 translate-middle-y me-2 border-0 bg-transparent"
                        onclick="togglePasswordConfirmationVisibility()">
                        <i class="bi bi-eye-slash" id="toggleConfirmPasswordIcon"></i>
                    </button>
                </div>

                @error('email')
                    <div class="text-danger small mb-2">{{ $message }}</div>
                @enderror

                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-outline-dark btn-lg">Daftar</button>
                </div>

                <div class="text-center mt-2">
                    <span class="normal">Sudah punya akun? <a href="{{ route('login') }}"
                            class="text-primary text-decoration-none">Masuk</a></span>
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

        function togglePasswordConfirmationVisibility() {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const icon = document.getElementById('toggleConfirmPasswordIcon');

            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                confirmPasswordInput.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    </script>
@endpush
