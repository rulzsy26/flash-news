@extends('layouts.main')

@section('title', Str::limit($article['title'] ?? 'Detail Berita', 60))

@section('content')
    <div class="container py-4">
        <div class="row">
            {{-- Konten Berita --}}
            <div class="col-lg-8">
                <h3 class="mb-3 text-primary" style="font-weight: bold;">
                    {{ $article['title'] ?? 'Judul tidak tersedia' }}
                </h3>
                <p class="text-muted mb-3">
                    By <strong>{{ $article['author'] ?? ($article['source']['name'] ?? 'Sumber tidak diketahui') }}</strong>
                    |
                    {{ \Carbon\Carbon::parse($article['publishedAt'] ?? now())->translatedFormat('d M Y') }}
                </p>
                <img src="{{ $article['urlToImage'] ?? 'https://placehold.co/800x400?text=No+Image' }}" alt="News Image"
                    class="img-fluid mb-4 rounded" style="width: 100%; max-height: 400px; object-fit: cover;">
                @if (Auth::check())
                    @php
                        $saved = \App\Models\SavedArticle::where('user_id', auth()->id())
                            ->where('article_data->url', $article['url'])
                            ->first();
                    @endphp

                    @if ($saved)
                        {{-- Tombol Hapus Berita --}}
                        <form action="{{ route('news.unsave', ['id' => $saved->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Hapus Berita
                            </button>
                        </form>
                    @else
                        {{-- Tombol Simpan Berita --}}
                        <form action="{{ route('news.save') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="article" value="{{ json_encode($article) }}">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-bookmark"></i> Simpan Berita
                            </button>
                        </form>
                    @endif
                @else
                    {{-- Tombol Login jika belum login --}}
                    <div class="mt-1 mb-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="showLoginAlert()">
                            <i class="fas fa-bookmark"></i> Simpan Berita
                        </button>
                    </div>
                @endif

                <article style="line-height: 1.8; font-size: 1.1rem;">
                    {!! $article['content'] ?? ($article['description'] ?? 'Konten tidak tersedia.') !!}
                </article>

                <div class="mt-4">
                    <a href="{{ $article['url'] ?? '#' }}" class="btn btn-outline-primary" target="_blank">
                        Baca Selengkapnya di Sumber Asli
                    </a>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="mb-4">
                    <h5 class="fw-bold border-bottom pb-2">Berita Terbaru</h5>
                    @foreach (array_slice($latestNews['articles'] ?? [], 0, 3) as $newsItem)
                        @if (is_array($newsItem))
                            <div class="d-flex mb-3">
                                <img src="{{ $newsItem['urlToImage'] ?? 'https://placehold.co/100x70?text=No+Image' }}"
                                    class="me-2 rounded" style="width: 100px; height: 70px; object-fit: cover;">
                                <div>
                                    <a href="{{ route('berita.detail', ['encoded' => base64_encode(json_encode($newsItem))]) }}"
                                        class="text-dark fw-semibold d-block" style="font-size: 0.9rem;">
                                        {{ Str::limit(data_get($newsItem, 'title', 'Tanpa Judul'), 50) }}
                                    </a>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($newsItem['publishedAt'] ?? now())->translatedFormat('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>

                <div>
                    <h5 class="fw-bold border-bottom pb-2">Trending</h5>
                    @foreach (array_slice($trendingNews['articles'] ?? ($trendingNews ?? []), 0, 3) as $trend)
                        <div class="d-flex mb-3">
                            <img src="{{ $trend['urlToImage'] ?? 'https://placehold.co/100x70?text=No+Image' }}"
                                class="me-2 rounded" style="width: 100px; height: 70px; object-fit: cover;">
                            <div>
                                <a href="{{ route('berita.detail', ['encoded' => base64_encode(json_encode($trend))]) }}"
                                    class="text-dark fw-semibold d-block" style="font-size: 0.9rem;">
                                    {{ Str::limit($trend['title'], 50) }}
                                </a>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($trend['publishedAt'] ?? now())->translatedFormat('d M Y') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showLoginAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'Login Diperlukan',
                text: 'Silakan login terlebih dahulu untuk menyimpan berita.',
                confirmButtonText: 'Login',
                customClass: {
                    confirmButton: 'btn btn-lg btn-outline-primary px-4 py-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }

        // Tampilkan alert sukses jika berita berhasil disimpan
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-lg btn-success px-4 py-2'
                },
                buttonsStyling: false
            });
        @endif
    </script>
@endpush
