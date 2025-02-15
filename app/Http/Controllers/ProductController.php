<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService  = $productService;
    }

    public function index()
    {
        return response()->json($this->productService->getAllProducts());
    }

    public function byCategory($categoryId)
    {
        return response()->json($this->productService->getProductsByCategoryId($categoryId));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $result = $this->productService->updateProduct(
            $product,
            $request->input('product_number', $product->product_number),
            $request->input('sku', $product->sku),
            $request->input('regular_price', $product->regular_price),
            $request->input('sale_price', $product->sale_price)
        );

        return response()->json($result);
    }

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'Product deleted']);
    }
}
