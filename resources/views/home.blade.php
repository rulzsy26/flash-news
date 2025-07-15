@extends('layouts.main')

@section('title', 'Berita Terkini')

@section('content')
    <div class="container my-4">
        <div class="row flex-column-reverse flex-md-row mb-4">
            <!-- Carousel -->
            <div class="col-md-8">
                <div id="featuredNewsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach (array_slice($featuredNews['articles'] ?? [], 0, 5) as $index => $article)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $article['urlToImage'] ?? 'https://placehold.co/800x400?text=No+Image' }}"
                                    class="d-block w-100 img-fluid rounded"
                                    style="min-height: 200px; max-height: 500px; object-fit: cover;"
                                    alt="{{ $article['title'] }}">
                                <div class="carousel-caption bg-dark bg-opacity-50 rounded p-2">
                                    @php $encodedArticle = urlencode(base64_encode(json_encode($article))); @endphp
                                    <a href="{{ route('berita.detail', ['encoded' => $encodedArticle]) }}"
                                        class="text-white text-decoration-none">
                                        <h5>{{ $article['title'] }}</h5>
                                        <p>{{ $article['description'] }}</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#featuredNewsCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#featuredNewsCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-md-4 mb-3">
                <!-- Weather Widget -->
                <div class="weather-widget text-center mb-4">
                    <h5>{{ $weather['location'] }}</h5>
                    <p class="text-muted">{{ $weather['city'] }}</p>
                    <p>{{ $weather['date'] }}</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="me-3">
                            <i class="{{ $weather['icon'] }}" style="font-size: 3rem;"></i>
                        </div>
                        <div>
                            <h2 class="mb-0">{{ $weather['temperature'] }}</h2>
                        </div>
                    </div>
                </div>

                <!-- Popular Categories -->
                <div>
                    <h4 class="category-title">Kategori Terpopuler</h4>
                    <ol class="list-group list-group-numbered">
                        @foreach ($popularCategories as $name => $slug)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <a href="{{ route('category', $slug) }}"
                                        class="text-decoration-none text-dark">{{ $name }}</a>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>

        <!-- Trending News -->
        <div class="mt-4">
            <h4 class="category-title">Trending</h4>
            <div class="row">
                @foreach (array_slice($trendingNews['articles'], 0, 6) as $article)
                    <div class="col-12 col-sm-6 col-md-4 d-flex mb-4">
                        <div class="card h-100 w-100">
                            @php $encodedArticle = urlencode(base64_encode(json_encode($article))); @endphp
                            <a href="{{ route('berita.detail', ['encoded' => $encodedArticle]) }}"
                                class="text-decoration-none text-dark w-100">
                                <img src="{{ $article['urlToImage'] ?? 'https://placehold.co/300x200?text=No+Image' }}"
                                    class="card-img-top" style="height: 200px; object-fit: cover;"
                                    alt="{{ $article['title'] ?? 'News Image' }}">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title">
                                        {{ Str::limit($article['title'] ?? 'Lorem ipsum dolor sit amet', 60) }}
                                    </h6>
                                    <p class="text-muted mb-0 mt-auto" style="font-size: 0.875rem;">
                                        {{ $article['author'] ?? ($article['source']['name'] ?? 'Sumber tidak diketahui') }}
                                        &bull;
                                        {{ \Carbon\Carbon::parse($article['publishedAt'])->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Berita Lainnya -->
        <div class="all-news mt-5">
            <h4 class="category-title">Berita Lainnya</h4>
            <div class="row">
                @php
                    $sortedArticles = collect($latestNews['articles'] ?? [])
                        ->sortByDesc(fn($article) => \Carbon\Carbon::parse($article['publishedAt']))
                        ->take(15)
                        ->values()
                        ->all();
                @endphp

                @if (!empty($sortedArticles))
                    @foreach ($sortedArticles as $article)
                        @php $encodedArticle = urlencode(base64_encode(json_encode($article))); @endphp
                        <div class="col-12 col-sm-6 col-md-4 mb-4">
                            <a href="{{ route('berita.detail', ['encoded' => $encodedArticle]) }}"
                                class="text-decoration-none text-dark">
                                <div class="card h-100">
                                    <img src="{{ $article['urlToImage'] ?? 'https://placehold.co/300x200?text=No+Image' }}"
                                        class="card-img-top" style="height: 200px; object-fit: cover;"
                                        alt="{{ $article['title'] ?? 'News Image' }}">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            {{ Str::limit($article['title'] ?? 'Judul tidak tersedia', 60) }}
                                        </h6>
                                        <p class="text-muted mb-0" style="font-size: 0.875rem;">
                                            {{ $article['author'] ?? ($article['source']['name'] ?? 'Sumber tidak diketahui') }}
                                            &bull;
                                            {{ \Carbon\Carbon::parse($article['publishedAt'])->translatedFormat('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    @for ($i = 0; $i < 6; $i++)
                        <div class="col-12 col-sm-6 col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="https://placehold.co/300x200?text=No+Image" class="card-img-top" alt="News Image">
                                <div class="card-body">
                                    <h6 class="card-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit</h6>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('berita') }}" class="btn btn-outline-dark">Lihat Lainnya</a>
            </div>
        </div>

    </div>

    {{-- Tambahan CSS responsif --}}
    @push('styles')
        <style>
            .category-title {
                font-weight: 600;
                margin-bottom: 1rem;
            }

            @media (max-width: 576px) {
                .card-title {
                    font-size: 1rem;
                }

                .carousel-caption {
                    font-size: 0.9rem;
                    padding: 0.5rem;
                }
            }
        </style>
    @endpush
@endsection
