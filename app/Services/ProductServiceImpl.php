<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductServiceImpl implements ProductService
{
    public function getAllProducts(): Collection
    {
        return Product::with(['category', 'department', 'manufacturer'])->get();
    }

    public function getProductsByCategoryId(int $categoryId): Collection
    {
        return Product::with(['category', 'department', 'manufacturer'])
            ->where('category_id', $categoryId)
            ->get();
    }

    public function updateProduct(Product $product, $productNumber, $sku, $regularPrice, $salePrice): Product
    {
        $product->product_number = $productNumber;
        $product->sku = $sku;
        $product->regular_price = $regularPrice;
        $product->sale_price = $salePrice;

        $product->save();

        return $product;
    }

    public function deleteProduct(int $productId): void
    {
        $product = Product::findOrFail($productId);
        $product->delete();
    }
}
