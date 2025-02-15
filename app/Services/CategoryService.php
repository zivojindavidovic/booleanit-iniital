<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

interface CategoryService
{
    public function getAllCategories(): Collection;

    public function updateCategory(int $categoryId, string $categoryName): Category;

    public function deleteCategory(int $categoryId): void;
}
