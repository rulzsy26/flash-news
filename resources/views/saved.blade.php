@extends('layouts.main')

@section('content')
    <div class="container my-5">
        <h2 class="text-center mb-4" style="font-weight: 600;">Berita Tersimpan</h2>

        @if ($savedArticles->isEmpty())
            <p class="text-center text-muted">Tidak ada berita yang disimpan.</p>
        @else
            @foreach ($savedArticles as $saved)
                @php
                    $article = $saved->article_data; // Tanpa json_decode
                    $detailUrl = route('berita.detail', ['encoded' => base64_encode(json_encode($article))]);
                @endphp

                <div class="d-flex justify-content-between align-items-start p-3 mb-3 bg-light rounded shadow-sm"
                    style="border-radius: 12px;">
                    {{-- Thumbnail dan teks berita --}}
                    <a href="{{ $detailUrl }}" class="d-flex text-decoration-none text-dark w-100 me-3">
                        <img src="{{ $article['urlToImage'] ?? asset('images/default.jpg') }}" alt="News Image"
                            style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-right: 16px;">

                        <div>
                            <p class="mb-2" style="font-weight: 500;">
                                {{ Str::limit($article['description'] ?? ($article['title'] ?? 'Deskripsi tidak tersedia'), 200) }}
                            </p>
                            <small class="text-muted">
                                By {{ $article['author'] ?? 'Unknown' }},
                                {{ \Carbon\Carbon::parse($article['publishedAt'])->translatedFormat('F Y') }}
                            </small>
                        </div>
                    </a>

                    {{-- Tombol hapus --}}
                    <form action="{{ route('news.unsave', $saved->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-secondary btn-sm rounded-circle" title="Hapus"
                            style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-color: #6c757d; color: #6c757d;"
                            onmouseover="this.style.backgroundColor='black'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='#6c757d';">
                            &#x2715;
                        </button>

                    </form>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $savedArticles->onEachSide(1)->links('vendor.pagination.bootstrap-4') }}
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ e(session('success')) }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif


@endsection
