<?php

namespace App\Http\Controllers;

use App\Category;
use App\Code;
use App\CodeCategory;
use Facade\FlareClient\Http\Response;
use Facade\FlareClient\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function categories_options_link(Code $code){

        $codes_categories = CodeCategory::where('code_id', $code->id)->pluck('category_id');
        $categories = Category::whereNotIn('id', $codes_categories)->get();

        return view('app.category.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function code_link_categories(Request $request){

        CodeCategory::unguard();
        $code = Code::find($request->id);
        $code->categories()->attach($request->get('categories'));
        CodeCategory::reguard();
        return response()->json($code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required',
            'description' => 'required|min:3',
            'memo' => 'required|min:3',
            'user_id' => 'exists:users,id',
            'project_id' => 'exists:projects,id',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        Category::unguard();
        $category =  Category::create($request->except('_token'));
        Category::reguard();
        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->code_categories()->delete();

        Category::unguard();
        foreach($category->sub_categories() as $sub){
            $sub->category_id = null;
            $super = Category::find($sub->id);
            $super->update($sub->all());
        }
        Category::reguard();

        $category->delete();
        return response()->json($category);
    }
}
