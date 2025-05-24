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

    /**
     * Create a new import instance.
     *
     * @param  array  $fields
     * @return void
     */
    public function __construct(array $fields)
    {
        $this->fields = $fields;
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
                switch ($field) {
                    case 'name':
                    case 'description':
                    case 'price':
                    case 'stock':
                        if (isset($row[$this->getColumnName($field)])) {
                            $productData[$field] = $row[$this->getColumnName($field)];
                        }
                        break;
                    case 'category_id':
                        if (isset($row[$this->getColumnName($field)])) {
                            $categoryName = $row[$this->getColumnName($field)];
                            $category = Category::where('name', $categoryName)->first();
                            if ($category) {
                                $productData[$field] = $category->id;
                            }
                        }
                        break;
                    case 'is_featured':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $productData[$field] = in_array(strtolower($value), ['yes', '1', 'true']);
                        }
                        break;
                    case 'specifications':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $productData[$field] = is_string($value) ? json_decode($value, true) : $value;
                        }
                        break;
                    case 'available_from':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $productData[$field] = $value ? \Carbon\Carbon::parse($value) : null;
                        }
                        break;
                }
            }
            
            // Only proceed if we have a name and category_id
            if (!empty($productData['name']) && !empty($productData['category_id'])) {
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
    }
    
    /**
     * Get the column name from the Excel file.
     *
     * @param  string  $field
     * @return string
     */
    private function getColumnName($field)
    {
        // Map field names to Excel column names
        $columnMap = [
            'id' => 'id',
            'uuid' => 'uuid',
            'category_id' => 'category',
            'name' => 'name',
            'description' => 'description',
            'price' => 'price',
            'stock' => 'stock',
            'is_featured' => 'featured',
            'specifications' => 'specifications',
            'available_from' => 'available_from',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
        
        return $columnMap[$field] ?? $field;
    }
}
