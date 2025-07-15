@extends('layouts.main')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Tentang <span class="fst-italic">FLASH</span><span
                    class="text-primary fst-italic">NEWS</span></h1>
            <p class="lead">Membawa berita dari seluruh dunia langsung ke genggaman Anda.</p>
        </div>

        <div class="row mb-5 justify-content-center">
            <div class="col-md-8 text-center">
                <h3><i class="bi bi-lightning-charge text-warning"></i> Siapa Kami?</h3>
                <p><strong>FlashNews</strong> adalah platform berita daring yang menyajikan informasi terkini dari berbagai
                    sumber terpercaya melalui News API. Tujuan kami adalah menyampaikan berita dengan cepat, akurat, dan
                    mudah dipahami untuk semua kalangan.</p>
            </div>
        </div>

        <div class="row mb-5 justify-content-center align-items-stretch">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-eye-fill text-primary display-5 mb-3"></i>
                        <h5 class="card-title">Visi Kami</h5>
                        <p class="card-text">Menjadi sumber berita digital terpercaya dan berdampak positif melalui
                            informasi yang akurat dan berkualitas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title text-center"><i class="bi bi-bullseye text-success"></i> Misi Kami</h5>
                        <ul class="list-unstyled mt-3">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Menyajikan berita terkini dari
                                seluruh dunia dengan cepat.</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Memanfaatkan teknologi untuk
                                menyaring dan menampilkan berita relevan.</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i> Memberikan pengalaman pengguna
                                yang nyaman dan efisien.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5 justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-3">
                            <i class="bi bi-people-fill text-info"></i> Tim Pengembang
                        </h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Muhamad Syahrul Adha</strong> – Developer & UI Designer
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
