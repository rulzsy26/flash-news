@extends('layouts.main')

@section('title', 'Lupa Password')

@section('content')
    <div class="container mt-5" style="max-width: 500px;">
        <h4 class="text-primary text-center mb-4">Lupa Kata Sandi</h4>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Masukkan Email"
                    required>
            </div>
            @error('email')
                <div class="text-danger small mb-2">{{ $message }}</div>
            @enderror

            <div class="d-grid">
                <button type="submit" class="btn btn-outline-dark btn-lg">Kirim Link Reset</button>
            </div>
        </form>
    </div>
@endsection
