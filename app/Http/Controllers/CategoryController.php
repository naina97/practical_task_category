<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::with('children');

        $searchText = $request->q;
        if ($searchText && !empty($searchText)) {
    
            $query->where(function ($q) use ($searchText) {
                $q->where('name', 'LIKE', "%{$searchText}%")
                  ->orWhereHas('children', function ($subQuery) use ($searchText) {
                      $subQuery->where('name', 'LIKE', "%{$searchText}%");
                  });
            });
        }
    
        $categories = $query->whereNull('parent_id')->get();

        return view('categories.index', compact('categories','searchText'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('categories.add_category',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validationRule    = [];
        $validationMessage = [];

        $validationRule = [
            'category_name'  => 'required',
            'parent_id' => 'nullable|exists:categories,id',

        ];
        
        $validationMessage = [
            'category_name.required'  => 'Category Name is required.',
        ];
        $validatedData     = $request->validate($validationRule, $validationMessage);

        try {

                $category = new Category();
                $category->name = $request->category_name;
                $category->parent_id = $request->parent_id ?? null;
                    
            if ($category->save()) {
                $status = 'success';
                $message_text = 'Category added successful';
            } else {
                $status = 'error';
                $message_text = 'Category failed';
            }
            
        } catch (Throwable $e) {
            $status = 'error';
            $message_text = 'Category  failed: ' . $e->getMessage();
        }
        
        return redirect()->route('category.index')->with($status, $message_text);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categories = Category::whereNull('parent_id')->where('id', '!=', $id)->get(); // Exclude current category to avoid self-parenting
        return view('categories.add_category', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validationRule    = [];
        $validationMessage = [];

        $validationRule = [
            'category_name'  => 'required',
            'parent_id' => 'nullable|exists:categories,id',

        ];
        
        $validationMessage = [
            'category_name.required'  => 'Category Name is required.',
        ];
        $validatedData     = $request->validate($validationRule, $validationMessage);
        
        $category = Category::find($id);
        try {
                $category->name = $request->category_name;
                $category->parent_id = $request->parent_id ?? null;
                    
                if ($category->save()) {
                    $status = 'success';
                    $message_text = 'Category updated successful';
                } else {
                    $status = 'error';
                    $message_text = 'Failed to update category';
                }
        } catch (Throwable $e) {
            $status = 'error';
            $message_text = 'Category  failed: ' . $e->getMessage();
        }
        
        return redirect()->route('category.index')->with($status, $message_text);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        //subcategory count male to delete na thavu joiye other wise category delete thavi joiye.
        $subCategoryCount = Category::where('parent_id', $id)->count();
        if ($subCategoryCount > 0) {
            $status = 'error';
            $message_text = 'Category cannot be deleted as it has subcategories.';
            return redirect()->route('category.index')->with($status, $message_text);
        }
       
        $category->delete();
        $status = 'success';
        $message_text = 'Category deleted successful';
        return redirect()->route('category.index')->with($status, $message_text);
    
    
    }
}
