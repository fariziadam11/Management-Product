<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    /**
     * The fields to import.
     *
     * @var array
     */
    protected $fields;
    protected $columnMap = [];
    protected $errors = [];

    /**
     * Create a new import instance.
     *
     * @param  array  $fields
     * @return void
     */
    /**
     * @param array $fields Fields to import (model fields)
     * @param array $columnMap Map of model field => file column name
     */
    public function __construct(array $fields, array $columnMap = [])
    {
        $this->fields = $fields;
        $this->columnMap = $columnMap;
    }

    /**
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $productData = [];

            // Map fields from Excel to model
            foreach ($this->fields as $field) {
                $column = $this->getColumnName($field);
                switch ($field) {
                    case 'name':
                    case 'description':
                    case 'price':
                    case 'stock':
                        if (isset($row[$column])) {
                            $productData[$field] = $row[$column];
                        }
                        break;
                    case 'category_id':
                        if (isset($row[$column])) {
                            $categoryName = $row[$column];
                            $category = Category::where('name', $categoryName)->first();
                            if ($category) {
                                $productData[$field] = $category->id;
                            } else {
                                $this->errors[] = "Row {$row['__rowNum__']}: Category '{$categoryName}' not found.";
                            }
                        }
                        break;
                    case 'is_featured':
                    case 'specifications':
                    case 'available_from':
                        if (isset($row[$column])) {
                            $value = $row[$column];
                            switch ($field) {
                                case 'is_featured':
                                    $productData[$field] = in_array(strtolower($value), ['yes', '1', 'true']);
                                    break;
                                case 'specifications':
                                    $productData[$field] = is_string($value) ? json_decode($value, true) : $value;
                                    break;
                                case 'available_from':
                                    $productData[$field] = $value ? \Carbon\Carbon::parse($value) : null;
                                    break;
                            }
                        }
                        break;
                }
            }

            // Only proceed if we have a name and category_id
            if (empty($productData['name'])) {
                $this->errors[] = "Row {$row['__rowNum__']}: Missing product name.";
                continue;
            }
            if (empty($productData['category_id'])) {
                $this->errors[] = "Row {$row['__rowNum__']}: Missing or invalid category.";
                continue;
            }
            // Check if product exists by name and category
            $product = Product::where('name', $productData['name'])
                            ->where('category_id', $productData['category_id'])
                            ->first();

            if ($product) {
                // Update existing product
                $product->update($productData);
            } else {
                // Create new product with UUID
                $productData['uuid'] = (string) Str::uuid();
                Product::create($productData);
            }
        }
    }

    /**
     * Get the column name from the Excel file.
     *
     * @param  string  $field
     * @return string
     */
    private function getColumnName($field)
    {
        // Use user-provided mapping if available
        return $this->columnMap[$field] ?? $field;
    }
}
