<?php
namespace App\Repositories\Articles;

use App\Models\Article;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;

class ElasticsearchArticlesRepository implements ArticlesRepository
{
    private $search;

    public function __construct(Client $client) {
        $this->search = $client;
    }

    public function search(string $query = ""): Collection
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query): array
    {
        $instance = new Article;

        $items = $this->search->search([
            'index' => $instance->getSearchIndex(),
            'type' => $instance->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title', 'body', 'tags'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection(array $items): Collection
    {
        /**
         * Data yang dimuat akan tampil seperti struktur dibawah ini
         *
         * [
         *      'hits' => [
         *          'hits' => [
         *              [ '_source' => 1 ],
         *              [ '_source' => 2 ],
         *          ]
         *      ]
         * ]
         *
         * Kita hanya membutuhkan source dari dokumen tersebut
        */
        $hits = array_pluck($items['hits']['hits'], '_source') ?: [];

        $sources = array_map(function ($source) {
            // metod hydrate akan mencoba men decode field tersebut, sedangkan ES sudah mempersiapkan arraynya
            $source['tags'] = json_encode($source['tags']);
            return $source;
        }, $hits);

        // Kita harus meng konfersi hasil array kedalam eloquent models
        return Article::hydrate($sources);
    }
}
