<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Load Categories in sidebar views
         */
        view()->composer('layouts.includes.side-bar', function ($view) {
            $categories = DB::table('categories')
                ->orderBy('categories.name', 'ASC')
                ->get();
            return $view->with('categories', $categories);
        });

        /*
         * Load Recent books in  sidebar views
         */
        view()->composer('layouts.includes.side-bar', function ($view) {
            $recentBooks = DB::table('books')
                ->select('books.*','authors.name as author_name', 'images.file as image_url')
                ->join('images', 'books.image_id', '=', 'images.id')
                ->join('authors', 'books.author_id', '=', 'authors.id')
                ->latest()
                ->take(4)
                ->get();
            return $view->with('recent_books', $recentBooks);
        });

    }
}
