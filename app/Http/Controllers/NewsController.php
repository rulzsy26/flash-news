<?php

namespace App\Http\Controllers;

use App\Services\NewsApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\SavedArticle;
use Illuminate\Support\Facades\Auth;

class NewsController
{
    protected $newsApiService;

    public function __construct(NewsApiService $newsApiService)
    {
        $this->newsApiService = $newsApiService;
    }

    public function index()
    {
        // Inisialisasi default
        $weather = null;

        $featuredNews = $this->newsApiService->getTopHeadlines(['pageSize' => 1]);
        $trendingNews = $this->newsApiService->getTopHeadlines(['pageSize' => 6]);
        $page = request()->get('page', 1);
        $latestNews = $this->newsApiService->getEverything('news', 21, $page);

        session([
            'latestNews' => ['articles' => $latestNews['articles']],
            'trendingNews' => ['articles' => $trendingNews['articles']]
        ]);

        $categories = [
            'business',
            'entertainment',
            'health',
            'science',
            'sports',
            'technology'
        ];

        $popularCategories = [
            'Olahraga' => 'sports',
            'Politik' => 'politics',
            'Ekonomi' => 'business',
            'Lingkungan' => 'health',
            'Hiburan' => 'entertainment'
        ];

        // Cuaca
        $weatherApiKey = getenv('WEATHER_API_KEY'); 
        $city = 'Jakarta';
        $weatherUrl = "http://api.weatherapi.com/v1/current.json?key=$weatherApiKey&q=" . urlencode($city) . "&aqi=no";
        try {
            $weatherResponse = file_get_contents($weatherUrl);
            $weatherData = json_decode($weatherResponse, true);

            if ($weatherData && isset($weatherData['location'], $weatherData['current'])) {
                $weatherIcons = [
                    'sunny' => 'fas fa-sun text-warning',
                    'partly cloudy' => 'fas fa-cloud-sun text-secondary',
                    'cloudy' => 'fas fa-cloud text-secondary',
                    'overcast' => 'fas fa-smog text-muted',
                    'mist' => 'fas fa-smog text-muted',
                    'light rain' => 'fas fa-cloud-rain text-primary',
                    'light rain shower' => 'fas fa-cloud-rain text-primary',
                    'moderate rain' => 'fas fa-cloud-showers-heavy text-primary',
                    'moderate or heavy rain shower' => 'fas fa-cloud-showers-heavy text-primary',
                    'heavy rain' => 'fas fa-cloud-showers-heavy text-primary',
                    'thunderstorm' => 'fas fa-bolt text-warning',
                    'clear' => 'fas fa-sun text-warning',
                    'rain' => 'fas fa-cloud-showers-heavy text-primary',
                    'haze' => 'fas fa-smog text-muted',
                    'fog' => 'fas fa-smog text-muted',
                    // Tambah sesuai kondisi dari WeatherAPI
                ];


                $conditionText = strtolower($weatherData['current']['condition']['text']);
                $iconClass = 'fas fa-question-circle text-muted'; // default

                if (str_contains($conditionText, 'sunny') || str_contains($conditionText, 'clear')) {
                    $iconClass = 'fas fa-sun text-warning';
                } elseif (str_contains($conditionText, 'partly')) {
                    $iconClass = 'fas fa-cloud-sun text-secondary';
                } elseif (str_contains($conditionText, 'cloud')) {
                    $iconClass = 'fas fa-cloud text-secondary';
                } elseif (str_contains($conditionText, 'rain') || str_contains($conditionText, 'shower')) {
                    $iconClass = 'fas fa-cloud-showers-heavy text-primary';
                } elseif (str_contains($conditionText, 'fog') || str_contains($conditionText, 'mist') || str_contains($conditionText, 'haze')) {
                    $iconClass = 'fas fa-smog text-muted';
                } elseif (str_contains($conditionText, 'thunder')) {
                    $iconClass = 'fas fa-bolt text-warning';
                }

                $weather = [
                    'location' => 'Cuaca Hari Ini',
                    'city' => strtoupper($weatherData['location']['name']) . ', ' . strtoupper($weatherData['location']['country']),
                    'date' => date('d M Y'),
                    'temperature' => $weatherData['current']['temp_c'] . '°C',
                    'condition' => $conditionText,
                    'icon' => $iconClass
                ];
            }
        } catch (\Exception $e) {
            // log error kalau perlu
        }

        return view('home', compact(
            'featuredNews',
            'trendingNews',
            'latestNews',
            'weather',
            'popularCategories'
        ));
    }

    public function category($category)
    {
        $news = $this->newsApiService->getNewsByCategory($category);
        return view('category', compact('news', 'category'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $news = $this->newsApiService->getEverything($query);
        return view('search', compact('news', 'query'));
    }

    public function detail(Request $request)
    {
        $articleData = json_decode(base64_decode($request->data), true);

        $apiKey = env('NEWS_API_KEY');
        $category = 'general';
        $url = "https://newsapi.org/v2/top-headlines?country=id&category={$category}&apiKey={$apiKey}";
        $response = Http::get($url);
        $news = $response->json();

        return view('detail', [
            'article' => $articleData,
            'latestNews' => $news, // pastikan ini full response
            'trendingNews' => $news // atau array_slice($news['articles'], 0, 3)
        ]);
    }


    public function allNews(Request $request)
    {
        $perPage = 21;
        $page = $request->get('page', 1);
        $totalResults = 200;
        $lastPage = ceil($totalResults / $perPage);

        $news = $this->newsApiService->getEverything('news', $perPage, $page);

        return view('berita', [
            'news' => $news,
            'currentPage' => $page,
            'perPage' => $perPage,
            'totalResults' => $totalResults,
            'lastPage' => $lastPage,
        ]);
    }

    public function show($encoded)
    {
        $decoded = base64_decode($encoded);
        $newsItem = json_decode($decoded, true);

        if (!is_array($newsItem)) {
            abort(404, 'Data berita tidak valid.');
        }

        return view('detail', [
            'article' => $newsItem,
            'latestNews' => session('latestNews', ['articles' => []]),
            'trendingNews' => session('trendingNews', ['articles' => []])
        ]);
    }

    public function saved()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $savedArticles = SavedArticle::where('user_id', Auth::id())->paginate(5);

        return view('saved', compact('savedArticles'));
    }

    public function saveArticle(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Decode JSON dari form input
        $articleData = json_decode($request->input('article'), true);

        // Validasi
        if (!$articleData || !isset($articleData['url'])) {
            return redirect()->back()->with('error', 'Data artikel tidak valid.');
        }

        // Cek duplikasi berdasarkan URL yang sekarang disimpan sebagai kolom terpisah
        $existing = SavedArticle::where('user_id', Auth::id())
            ->where('url', $articleData['url']) // Gunakan kolom `url`
            ->first();

        if ($existing) {
            return redirect()->back()->with('info', 'Berita ini sudah tersimpan sebelumnya.');
        }

        // Simpan artikel
        SavedArticle::create([
            'user_id' => Auth::id(),
            'url' => $articleData['url'],         // Simpan URL ke kolom terpisah
            'article_data' => $articleData,       // Tetap simpan JSON lengkap
        ]);

        return redirect()->back()->with('success', 'Berita berhasil disimpan.');
    }

    public function unsave($id)
    {
        $savedArticle = SavedArticle::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$savedArticle) {
            return redirect()->back()->with('error', 'Berita tidak ditemukan atau bukan milik Anda.');
        }

        $savedArticle->delete();

        return redirect()->back()->with('success', 'Berita berhasil dihapus.');
    }
}
