<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookshopHomeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        # Home page Books
        $technologyInformationBooks = DB::table('books')
            ->select('books.*',
                'images.file as image_url',
                'authors.name as author_name',
                'categories.slug as category_slug')
            ->leftJoin('images', 'books.image_id', '=', 'images.id')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->rightJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('categories.slug', '=', 'technology-information')
            ->orderBy('books.id', 'desc')
            ->paginate(4);
        $informationSecurityBooks = DB::table('books')
            ->select('books.*',
                'images.file as image_url',
                'authors.name as author_name',
                'categories.slug as category_slug')
            ->leftJoin('images', 'books.image_id', '=', 'images.id')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->rightJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('categories.slug', '=', 'information-security')
            ->orderBy('books.id', 'desc')
            ->paginate(4);
        $computerScienceBooks = DB::table('books')
            ->select('books.*',
                'images.file as image_url',
                'authors.name as author_name',
                'categories.slug as category_slug')
            ->leftJoin('images', 'books.image_id', '=', 'images.id')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->rightJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('categories.slug', '=', 'computer-science')
            ->orderBy('books.id', 'desc')
            ->paginate(4);
        $categories = DB::table('categories')
            ->select('categories.*')
            ->get();
        $discount_books = DB::table('books')
            ->select('books.*', 'images.file as image_url', 'authors.name as author_name')
            ->leftJoin('images', 'books.image_id', '=', 'images.id')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->rightJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('books.discount_rate', '>', 0)
            ->orderBy('books.discount_rate', 'DESC')
            ->paginate(6);
        return view('public.home', compact('technologyInformationBooks',
            'informationSecurityBooks',
            'computerScienceBooks',
            'discount_books', 'categories'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function allBooks(Request $request)
    {
        if($request->input('term')){
            $search= $request->input('term');
            $books = DB::table('books')
                ->select('books.*', 'images.file as image_url', 'authors.name as author_name')
                ->join('images', 'books.image_id', '=', 'images.id')
                ->join('authors', 'books.author_id', '=', 'authors.id')
                ->where('books.title', 'LIKE', "%$search%")
                ->orderBy('books.id', 'desc')
                ->paginate(8);
        }else{
            $books = DB::table('books')
                ->select('books.*', 'images.file as image_url', 'authors.name as author_name')
                ->join('images', 'books.image_id', '=', 'images.id')
                ->join('authors', 'books.author_id', '=', 'authors.id')
                ->orderBy('books.id', 'desc')
                ->paginate(8);
        }
        $categories = $this->getCategories();
        return view('public.book-page', compact('books', 'categories'));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getCategories()
    {
        $categories = DB::table('categories')
            ->get();
        return $categories;
    }

    /**
     * @param $slugBook
     * @return Application|Factory|View
     */
    public function bookDetails($slugBook)
    {
        $book = DB::table('books')
            ->select('books.*',
                'images.file as image_url',
                'authors.name as author_name',
                'authors.slug as author_slug',
                'authors.bio as author_bio',
                'categories.name as category_name',
                'categories.slug as category_slug')
            ->join('images', 'books.image_id', '=', 'images.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->rightJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('books.slug', '=', $slugBook)
            ->first();
        $book_reviews = DB::table('reviews')
            ->select('books.id',
                'reviews.*',
                'users.name as user_name')
            ->leftJoin('books', 'books.id', '=', 'reviews.product_id')
            ->leftJoin('users', 'users.id', '=', 'reviews.user_id')
            ->latest()->get();
        $user_image = DB::table('images')
            ->select('images.id',
                'images.file as image_file',
            'users.image_id as user_image_id')
            ->leftJoin('users', 'users.image_id', '=', 'images.id')
            ->get();
        return view('public.book-details', compact('book', 'book_reviews', 'user_image'));
    }

    /**
     * @param $slugAuthor
     * @return int
     */
    public function author($slugAuthor){
        return 1;
    }

    /**
     * @return Application|Factory|View
     */
    public function discountBooks()
    {
        $books = DB::table('books')
            ->select('books.*', 'images.file as image_url', 'authors.name as author_name', 'categories.name as category_name')
            ->join('images', 'books.image_id', '=', 'images.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->rightJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('books.discount_rate', '>', 0)
            ->orderBy('books.id', 'desc')
            ->paginate(8);
        return view('public.book-page', compact('books'));
    }

    /**
     * @return Application|Factory|View
     */
    public function category(Request $request, $slugCategory)
    {
        $categoryName = DB::table('categories')
            ->select('categories.name')
            ->orderBy('categories.id', 'DESC')
            ->where('categories.slug', '=', $slugCategory)
            ->first();
        $categoryName = $categoryName->name;
        $books = $this->getBookBySlugCategory($slugCategory);
        return view('public.book-page', compact('books', 'categoryName'));
    }

    /**
     * @param $filterBySlugCategory
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getBookBySlugCategory($filterBySlugCategory)
    {
        $books = DB::table('books')
            ->select('books.*', 'images.file as image_url', 'authors.name as author_name', 'categories.name as category_name')
            ->join('images', 'books.image_id', '=', 'images.id')
            ->join('authors', 'books.author_id', '=', 'authors.id')
            ->rightJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('categories.slug', '=', $filterBySlugCategory)
            ->orderBy('books.id', 'desc')
            ->paginate(8);
        return $books;
    }
}
