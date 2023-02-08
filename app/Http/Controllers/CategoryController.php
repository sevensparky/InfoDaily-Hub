<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.layouts.categories.all',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.layouts.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[
        //     'name' => 'required|string|min:3|unique:categories'
        // ]);

        // auth()->user()->categories()->create($request->only('name'));

        $arrayItem = array();

        foreach ($request->name as $value) {
            // dump($value);

            $arrayItem[] = $value;

            // $names[] = array_push($value);



            // $category = new Category();
            // $category->name = $value;
            // $category->user_id = 5;
            // $category->save();
        }
        $names = implode(',', $arrayItem);

        $category = new Category();
        $category->name = $names;
        $category->user_id = auth()->id();
        $category->save();


        // die();
        toast('دسته مورد نظر با موفقیت ایجاد شد','success')->autoClose(3000);
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (auth()->user()->id === $category->user_id) {
            return view('admin.layouts.categories.edit',compact('category'));
        } else {
            toast('شما دسترسی لازم برای ویرایش این دسته را ندارید', 'warning')->autoClose(3000);
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,[
            'name' => 'required|string|min:3|unique:categories'
        ]);

        $category->update($request->only('name'));
        toast('دسته مورد نظر با موفقیت ویرایش شد','success')->autoClose(3000);
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        toast('دسته مورد نظر با موفقیت حذف شد','success')->autoClose(3000);
        return redirect(route('categories.index'));
    }


}
