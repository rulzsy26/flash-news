@extends('layouts.main')

@section('title', 'Reset Password')

@section('content')
    <div class="container mt-5" style="max-width: 500px;">
        <h4 class="text-primary text-center mb-4">Reset Kata Sandi</h4>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Kata Sandi Baru"
                    required>
            </div>

            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control form-control-lg"
                    placeholder="Konfirmasi Kata Sandi" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-outline-dark btn-lg">Reset Password</button>
            </div>
        </form>
    </div>
@endsection
