<?php
namespace App\Search\Articles;

trait Searchable
{
  public static function bootSearchable()
    {
        // Ini memudahkan untuk mengaktifkan tanda fitur pencarian
        // nyala dan mati. Ini akan terbukti bermanfaat nantinya
        // saat men deploy search engine baru ke aplikasi production
        if (config('services.search.enabled')) {
            static::observe(ElasticsearchObserver::class);
        }
    }

    public function getSearchIndex()
    {
        return $this->getTable();
    }

    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray()
    {
        // Dengan memiliki metode khusus yang mengubah model
        // ke array yang dapat dicari memungkinkan kita untuk menyesuaikan
        // data yang akan dapat ditelusuri per model.
        return $this->toArray();
    }
}
