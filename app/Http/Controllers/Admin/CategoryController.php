<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\CategoryFilter;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryResource;

class CategoryController extends Controller
{
    public function index(CategoryFilter $filters)
    {
        return CategoryResource::collection(Category::filter($filters)->paginate(5));
    }

    public function store(StoreCategoryRequest $request)
    {
        return response([
            'message' => __('category.store'),
            'category' => new CategoryResource($request->storeCategory())
        ]);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        return response([
            'message' => __('category.update'),
            'category' => new CategoryResource($request->updateCategory())
        ]);
    }

    public function destroy(Category $category)
    {
        $category->remove(); //handle the deletion of the relationships with the categories

        $category->delete();

        return response([
            'message' => __('category.delete')
        ]);
    }
}
