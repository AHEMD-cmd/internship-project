<?php

namespace App\Http\Controllers\Website;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Filters\Website\CategoryFilter;
use App\Http\Resources\Website\CategoryResource;

class CategoryController extends Controller
{
    public function index(CategoryFilter $filters)
    {
        return CategoryResource::collection(Category::filter($filters)->with('image')->paginate(5));
    }

    public function show(Category $category)
    {
        $category->load('image');

        return new CategoryResource($category);
    }
}
