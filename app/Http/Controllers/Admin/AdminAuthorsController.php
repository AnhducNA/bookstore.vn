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

class AdminAuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $authors = DB::table('authors')
            ->select('authors.*', 'images.file as image_url')
            ->leftJoin('images', 'authors.image_id', '=', 'images.id')
            ->leftJoin('books', 'authors.id', '=', 'books.author_id')
            ->orderBy('id', 'DESC')->get();
        foreach ($authors as $key => $author) {
            $count_books = DB::table('books')->where('books.author_id', '=', $author->id)->count();
            $authors[$key]->countBook = $count_books;
            if (empty($authors[$key]->image_url)) {
                $authors[$key]->image_url = "assets/img/default_user.png";
            }
        }
        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
//        get $currentTime
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentTime = (string)date('Y-m-d H:i:s', time());
//        validate
        $request->validate([
            'name' => 'required|max:100|unique:authors',
            'slug' => 'required|max:100|unique:authors',
            'bio' => 'required|min:6',
            'image_url' => 'max:500',
        ], [
            'required' => ':attribute is not empty',
            'min' => ':attribute minimum length of param is :min',
            'max' => ':attribute maximum length of param is :max',
            'unique' => ':attribute already exit',
        ]);
        $newAuthor = $request->all();
        $newAuthor['created_at'] = $currentTime;
        $newAuthor['image_id'] = strtok($request->input('image_url'), ".");
        unset($newAuthor['image_url']);
        unset($newAuthor['_token']);
        DB::table('authors')->insert($newAuthor);
        //        Insert images
        $image['id'] = strtok($request->input('image_url'), ".");
        $image['file'] = 'assets/img/' . $request->input('image_url');
        $image['created_at'] = $currentTime;
        DB::table('images')->insert($image);
        return redirect(route('authors.index'))
            ->with('success_message', 'Author create successfully');
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
        $author = DB::table('authors')
            ->select('authors.*', 'images.file as image_url')
            ->leftJoin('images', 'images.id', '=', 'authors.image_id')
            ->where('authors.id', '=', $id)
            ->first();
        if (empty($author->image_url)) {
            $author->image_url = "assets/img/default_user.png";
        }
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentTime = (string)date('Y-m-d H:i:s', time());

        $request->validate(
            [
                'name' => 'required|max:100|unique:authors,name,' . $id,
                'slug' => 'required|max:100|unique:authors,slug,' . $id,
                'bio' => 'required|min:6',
                'image_url' => 'max:500',
            ], [
                'required' => ':attribute is not empty',
                'min' => ':attribute minimum length of param is :min',
                'max' => ':attributecó maximum length of param is :max',
                'unique' => ':attribute already exit',
            ]
        );

        $dataUpdate = $request->all();
        $dataUpdate['updated_at'] = $currentTime;
        unset($dataUpdate['_token']);
        unset($dataUpdate['_method']);
        unset($dataUpdate['image_url']);
        DB::table('authors')
            ->where('authors.id', '=', $id)
            ->update($dataUpdate);
        return redirect(route('authors.index'))
            ->with('success_message', 'Author update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy($id)
    {
        $author = DB::table('authors')->find($id);
        DB::table('images')
            ->where('images.id', '=', $author->image_id)
            ->delete();
        DB::table('authors')
            ->where('authors.id', '=', $id)
            ->delete();
        return redirect(route('authors.index'))->with('success_message', 'Author deleted successfully');
    }
}
