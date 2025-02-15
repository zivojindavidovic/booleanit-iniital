<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Department;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Console\Command;
use League\Csv\Reader;

class ImportProductCategoriesCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:product-categories {file_path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import products from CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file_path');

        if (!file_exists($filePath)) {
            $this->error('File not found');
            return 1;
        }

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $offset => $record) {
            $categoryName     = $record['category_name'];

            //CSV has typo deparment instead of department
            $departmentName   = $record['deparment_name'] ?? '';
            $manufacturerName = $record['manufacturer_name'];
            $productNumber    = $record['product_number'];
            $sku              = $record['sku'];
            $regularPrice     = $record['regular_price'];
            $salePrice        = $record['sale_price'];
            $upc              = $record['upc'];

            $category = Category::firstOrCreate([
                'category_name' => $categoryName
            ]);

            $department = Department::firstOrCreate([
                'department_name' => $departmentName
            ]);

            $manufacturer = Manufacturer::firstOrCreate([
                'manufacturer_name' => $manufacturerName
            ]);

            Product::create([
                'product_id'     => $upc,
                'category_id'    => $category->category_id,
                'department_id'  => $department->department_id,
                'manufacturer_id'=> $manufacturer->manufacturer_id,
                'product_number' => $productNumber,
                'sku'            => $sku,
                'regular_price'  => $regularPrice ?: 0,
                'sale_price'     => $salePrice ?: 0
            ]);
        }

        $this->info("Import završen!");
        return 0;
    }
}
