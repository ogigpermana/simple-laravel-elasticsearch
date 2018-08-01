<?php

namespace App\Providers;

use Elasticsearch\Client;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Articles\ArticlesRepository;
use App\Repositories\Articles\EloquentArticlesRepository;
use App\Repositories\Articles\ElasticsearchArticlesRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      // $this->app->bind(ArticlesRepository::class, function () {
      //     return new EloquentArticlesRepository();
      // });

      $this->app->singleton(ArticlesRepository::class, function($app) {
          // Ini berguna jika kita ingin mematikannya
          // search cluster atau ketika men deploy pencarian
          // untuk aplikasi versi production, menjalankannya diawal.
            if (!config('services.search.enabled')) {
                return new EloquentArticlesRepository();
            }

            return new ElasticsearchArticlesRepository(
                $app->make(Client::class)
            );
        });

    }
}
