<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use League\Csv\Writer;
use SplTempFileObject;

class ExportController extends Controller
{
    public function exportCategoryProducts($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $products = Product::with(['category', 'department', 'manufacturer'])
            ->where('category_id', $categoryId)
            ->get();

        $csv = Writer::createFromFileObject(new SplTempFileObject());

        $csv->insertOne(['product_id','product_number','sku','regular_price','sale_price','department_name','manufacturer_name']);

        foreach ($products as $p) {
            $csv->insertOne([
                $p->product_id,
                $p->product_number,
                $p->sku,
                $p->regular_price,
                $p->sale_price,
                $p->department->department_name,
                $p->manufacturer->manufacturer_name
            ]);
        }

        $safeCategoryName = preg_replace('/[^a-zA-Z0-9]+/', '_', $category->category_name);

        $now = Carbon::now()->format('Y_m_d-H_i');
        $fileName = "{$safeCategoryName}_{$now}.csv";

        $csvContents = $csv->toString();

        return response($csvContents, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ]);
    }
}
