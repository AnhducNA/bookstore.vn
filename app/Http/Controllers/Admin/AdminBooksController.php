<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class AdminBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $books = DB::table('books')
            ->select('books.*',
                'categories.name as category_name',
                'authors.name as author_name',
                'images.file as image_file'
            )
            ->leftJoin('categories', 'categories.id', '=', 'books.category_id')
            ->leftJoin('authors', 'authors.id', '=', 'books.author_id')
            ->leftJoin('images', 'images.id', 'LIKE', 'books.image_id')
            ->orderBy('books.id', 'ASC')
            ->get();
//        dd($books);
        return view('admin.books.index', compact('books'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = DB::table('categories')->orderBy('categories.id', 'ASC')->get();
        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentTime = (string)date('Y-m-d H:i:s', time());
        DB::table('authors')
            ->insert(['name' => $request->input('author_name'),
                'slug' => $request->input('author_slug'),
                'bio' => $request->input('bio'),
                'created_at' => $currentTime]);
        $author = DB::table('authors')
            ->select('authors.*')
            ->where('authors.slug', '=', $request->input('author_slug'))
            ->first();
//        Insert book
        $dataUpdate['title'] = $request->input('title');
        $dataUpdate['slug'] = $request->input('slug');
        $dataUpdate['description'] = $request->input('description');
        $dataUpdate['author_id'] = $author->id;
        $dataUpdate['category_id'] = $request->input('category_id');
        $dataUpdate['image_id'] = strtok($request->input('image_url'), ".");
        $dataUpdate['quantity'] = $request->input('quantity');
        $dataUpdate['init_price'] = $request->input('init_price');
        $dataUpdate['discount_rate'] = $request->input('discount_rate');
        $dataUpdate['price'] = ceil((int)$request->input('init_price') * (100 - (int)$request->input('discount_rate')) / 100);
        $dataUpdate['created_at'] = $currentTime;
        DB::table('books')->insert($dataUpdate);
//        Insert image
        $image['id'] = strtok($request->input('image_url'), ".");
        $image['file'] = 'assets/img/' . $request->input('image_url');
        $image['created_at'] = $currentTime;
        DB::table('images')->insert($image);
        return redirect(route('books.index'))->with('success_message', 'Book updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $book = DB::table('books')
            ->select('books.*',
                'images.file as image_url',
                'authors.id as author_id',
                'authors.name as author_name',
                'categories.id as category_id',
                'categories.name as category_name',
            )
            ->leftJoin('images', 'books.image_id', '=', 'images.id')
            ->leftJoin('authors', 'books.author_id', '=', 'authors.id')
            ->rightJoin('categories', 'books.category_id', '=', 'categories.id')
            ->where('books.id', '=', $id)
            ->first();
        $authors = DB::table('authors')->orderBy('authors.id', 'ASC')->get();
        $categories = DB::table('categories')->orderBy('categories.id', 'ASC')->get();
//        dd($book);
        return view('admin.books.edit', compact('book', 'authors', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $dataUpdate['id'] = $id;
        $dataUpdate['title'] = $request->input('title');
        $dataUpdate['slug'] = $request->input('slug');
        $dataUpdate['description'] = $request->input('description');
        $dataUpdate['author_id'] = $request->input('author_id');
        $dataUpdate['category_id'] = $request->input('category_id');
        $dataUpdate['image_id'] = $request->input('image_id');
        $dataUpdate['quantity'] = $request->input('quantity');
        $dataUpdate['init_price'] = $request->input('init_price');
        $dataUpdate['discount_rate'] = $request->input('discount_rate');
        $dataUpdate['price'] = ceil((int)$request->input('init_price') * (100 - (int)$request->input('discount_rate')) / 100);
        $dataUpdate['updated_at'] = $request->input('updated_at');

        $book = DB::table('books')
            ->where('books.id', '=', $id)
            ->update($dataUpdate);

        $dataUpdate['image_url'] = $request->input('image_url');
        /**
         * Change image_url
         */
        $str = (string)$dataUpdate['image_url'];
        if (!(str_contains("$str", "assets/img"))) {
            $dataUpdate['image_url'] = 'assets/img/' . $dataUpdate['image_url'];
        }
        $image = DB::table('images')
            ->where('images.id', '=', $dataUpdate['image_id'])
            ->update(['file' => $dataUpdate['image_url']]);

        return redirect(route('books.index'))->with('success_message', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        $book = DB::table('books')->find($id);
        DB::table('images')
            ->where('images.id', '=', $book->image_id)
            ->delete();
        DB::table('books')
            ->where('books.id', '=', $id)
            ->delete();
        return redirect(route('books.index'))->with('success_message', 'Book deleted successfully');
    }

    /**
     * @return Application|Factory|View
     */
    public function trashBooks()
    {
        return view('admin.books.trash-books');
    }

    /**
     * @return Application|Factory|View
     */
    public function discountBooks()
    {
        return view('admin.books.index');
    }
}
