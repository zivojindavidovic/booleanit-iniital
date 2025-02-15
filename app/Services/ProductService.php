<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductService
{
    public function getAllProducts(): Collection;

    public function getProductsByCategoryId(int $categoryId): Collection;

    public function updateProduct(Product $product, $productNumber, $sku, $regularPrice, $salePrice): Product;

    public function deleteProduct(int $productId): void;
}
