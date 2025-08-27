<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // get all categories
    public function index(){
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    //get Category
    public function getCategory($id){
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    //create category
    public function store(Request $request){
        $validated = $request->validate([
            
            
        ]);

        $category = Category::create($validated);

        return response()->json(
            [
                'message' => 'Category created successfully',
                'data' => $category
            ], 500);
    }

    //update category
    public function updateCategory($id, Request $request){

        $category = Category::findOrFail($id);
        $validated = $request->validate([
           
            
        ]);

        $category->update($validated);
        return response()->json(
            [
                'message' => 'Category updated successfully',
                'data' => $category
            ], 500);
    }

    //delete category
    public function deleteCategory($id){
        {
            $category = Category::findOrFail($id);
            $category->delete();
        }

        return response()->json(
            [
                'message' => 'Category deleted successfully'
            ], 500);
    }
}