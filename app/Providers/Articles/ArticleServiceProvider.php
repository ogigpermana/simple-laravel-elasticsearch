<?php

namespace App\Providers\Articles;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use App\Repositories\Articles\ArticlesRepository;
use App\Repositories\Articles\EloquentArticlesRepository;
use App\Repositories\Articles\ElasticsearchArticlesRepository;
use Illuminate\Support\ServiceProvider;

class ArticleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts(config('services.search.hosts'))
                ->build();
        });
    }
}
