@extends('layouts.main')

@section('title', 'Semua Berita')

@section('content')
    <div class="container">
        <h3 class="mb-4">Semua Berita</h3>
        <div class="row">
            @php
                $articles = $news['articles'] ?? [];
                $totalPages = ceil($totalResults / $perPage);
            @endphp

            <div class="row">
                @foreach ($articles as $article)
                    @php
                        $encodedArticle = urlencode(base64_encode(json_encode($article)));
                    @endphp
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('berita.detail', ['encoded' => $encodedArticle]) }}"
                            class="text-decoration-none text-dark">
                            <div class="card h-100">
                                <img src="{{ $article['urlToImage'] ?? 'https://placehold.co/300x200?text=No+Image' }}"
                                    class="card-img-top" style="height: 200px; object-fit: cover;"
                                    alt="{{ $article['title'] ?? 'News Image' }}">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">{{ Str::limit($article['title'] ?? 'Judul tidak tersedia', 60) }}
                                    </h6>
                                    <p class="text-muted mb-0 mt-auto" style="font-size: 0.875rem;">
                                        {{ $article['author'] ?? ($article['source']['name'] ?? 'Sumber tidak diketahui') }}
                                        &bull;
                                        {{ \Carbon\Carbon::parse($article['publishedAt'])->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @php
                $lastPage = min(4, ceil($totalResults / $perPage)); // Maksimal 4 halaman
                $startPage = max(2, $currentPage - 1);
                $endPage = min($lastPage - 1, $currentPage + 1);
            @endphp

            <div class="text-center mt-4">
                <nav>
                    <ul class="pagination justify-content-center">

                        {{-- Previous --}}
                        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ route('berita', ['page' => max(1, $currentPage - 1)]) }}"
                                aria-label="Previous">&lt;</a>
                        </li>

                        {{-- Halaman 1 --}}
                        <li class="page-item {{ $currentPage == 1 ? 'active' : '' }}">
                            <a class="page-link" href="{{ route('berita', ['page' => 1]) }}">1</a>
                        </li>

                        {{-- Halaman tengah --}}
                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                                <a class="page-link" href="{{ route('berita', ['page' => $i]) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Halaman terakhir --}}
                        @if ($lastPage > 1)
                            <li class="page-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ route('berita', ['page' => $lastPage]) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next --}}
                        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ route('berita', ['page' => min($lastPage, $currentPage + 1)]) }}"
                                aria-label="Next">&gt;</a>
                        </li>

                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
