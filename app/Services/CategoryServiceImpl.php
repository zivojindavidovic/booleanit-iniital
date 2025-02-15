<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryServiceImpl implements CategoryService
{
    public function getAllCategories(): Collection
    {
        return Category::all();
    }

    public function updateCategory(int $categoryId, string $categoryName): Category
    {
        $category = Category::findOrFail($categoryId);
        $category->category_name = $categoryName;

        return $category;
    }

    public function deleteCategory(int $categoryId): void
    {
        $category = Category::findOrFail($categoryId);
        $category->delete();
    }
}
