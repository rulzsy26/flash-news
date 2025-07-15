@extends('layouts.main')

@section('title', ucfirst($category))

@section('content')
    <div class="container">
        <h2 class="mb-4">{{ ucfirst($category) }}</h2>

        <div class="row">
            @if (!empty($news['articles']) && count($news['articles']) > 0)
                @foreach ($news['articles'] as $article)
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
                                    <h5 class="card-title">{{ Str::limit($article['title'] ?? 'Judul tidak tersedia', 60) }}
                                    </h5>
                                    <p class="card-text mb-3">
                                        {{ Str::limit($article['description'] ?? 'Tidak ada deskripsi', 100) }}
                                    </p>
                                    <div class="mt-auto text-muted small">
                                        {{ \Carbon\Carbon::parse($article['publishedAt'] ?? now())->translatedFormat('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada berita untuk kategori ini.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
