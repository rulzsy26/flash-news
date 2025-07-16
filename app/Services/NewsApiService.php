<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsApiService
{
    protected $apiKey;
    protected $baseUrl = 'https://newsapi.org/v2';

    public function __construct()
    {
        $this->apiKey = getenv('NEWS_API_KEY');
    }

    public function getTopHeadlines($category = null, $pageSize = 10)
    {
        $endpoint = $this->baseUrl . '/top-headlines';

        $params = [
            'pageSize' => $pageSize,
            'country' => 'us', // ← Tambahkan ini
            'apiKey' => $this->apiKey,
        ];

        if ($category) {
            $params['category'] = $category;
        }

        $response = Http::get($endpoint, $params);

        if ($response->failed()) {
            \Log::error('NewsAPI Top Headlines request failed', [
                'url' => $endpoint,
                'params' => $params,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        return $response->json();
    }

    public function getEverything($query, $pageSize = 10, $page = 1)
    {
        $endpoint = $this->baseUrl . '/everything';

        $params = [
            'q' => $query,
            'pageSize' => $pageSize,
            'page' => $page,
            'apiKey' => $this->apiKey,
        ];

        $response = Http::get($endpoint, $params);
        return $response->json();
    }

    public function getNewsByCategory($category, $pageSize = 100, $page = 2)
    {
        return $this->getTopHeadlines($category, $pageSize);
    }


}