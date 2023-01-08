<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse as RedirectResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector as RedirectorAlias;
use Illuminate\Support\Facades\DB;

class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = DB::table('categories')
            ->get();
        $count_technologyInformationBooks = DB::table('books')
            ->where('books.category_id', '=', 1)
            ->count();
        $count_informationSecurityBooks = DB::table('books')
            ->where('books.category_id', '=', 2)
            ->count();
        $count_computerScienceBooks = DB::table('books')
            ->where('books.category_id', '=', 3)
            ->count();
        foreach ($categories as $key => $category) {
            if ($category->id == 1) {
                $categories[$key]->count = $count_technologyInformationBooks;
            } else if ($category->id == 2) {
                $categories[$key]->count = $count_informationSecurityBooks;
            } else if ($category->id == 3) {
                $categories[$key]->count = $count_computerScienceBooks;
            } else {
                $categories[$key]->count = 0;
            }
        }
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponseAlias|RedirectorAlias
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentTime = (string)date('Y-m-d H:i:s', time());

        $request->validate([
            'name' => 'required|max:100|unique:categories, Name',
            'slug' => 'required|max:100|unique:categories, Slug'
        ], [
            'required' => ':attribute is not empty',
            'max' => ':attribute maximum length of param is :max',
            'unique' => ':attribute already exit',
        ]);
        $input = $request->all();
        $input['created_at'] = $currentTime;
        unset($input['_token']);
        DB::table('categories')->insert($input);
        return redirect(route('categories.index'))
            ->with('success_message', 'Category create successfully');
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
        $category = DB::table('categories')->find($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|RedirectorAlias|RedirectResponseAlias
     */
    public function update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentTime = (string)date('Y-m-d H:i:s', time());

        $request->validate(
            [
                'name' => 'required|max:100|unique:categories,name,' . $id,
                'slug' => 'required|max:100|unique:categories,slug,' . $id
            ], [
                'required' => ':attribute is not empty',
                'max' => ':attributecó maximum length of param is :max',
                'unique' => ':attribute already exit',
            ]
        );
        $input = $request->all();
        $input['updated_at'] = $currentTime;
        unset($input['_token']);
        unset($input['_method']);
        DB::table('categories')
            ->where('categories.id', '=', $id)
            ->update($input);
        return redirect(route('categories.index'))
            ->with('success_message', 'Category update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|RedirectResponseAlias|RedirectorAlias
     */
    public function destroy($id)
    {
        DB::table('categories')
//            ->where('categories.id', '=', $id)
            ->delete($id);
        return redirect(route('categories.index'))
            ->with('success_message', 'Category delete successfully');
    }
}
