<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductReviewImport implements ToCollection, WithHeadingRow
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
            $reviewData = [];
            
            // Map fields from Excel to model
            foreach ($this->fields as $field) {
                switch ($field) {
                    case 'title':
                    case 'content':
                    case 'rating':
                        if (isset($row[$this->getColumnName($field)])) {
                            $reviewData[$field] = $row[$this->getColumnName($field)];
                        }
                        break;
                    case 'product_id':
                        if (isset($row[$this->getColumnName($field)])) {
                            $productName = $row[$this->getColumnName($field)];
                            $product = Product::where('name', $productName)->first();
                            if ($product) {
                                $reviewData[$field] = $product->id;
                            }
                        }
                        break;
                    case 'user_id':
                        if (isset($row[$this->getColumnName($field)])) {
                            $userName = $row[$this->getColumnName($field)];
                            $user = User::where('name', $userName)->first();
                            if ($user) {
                                $reviewData[$field] = $user->id;
                            }
                        }
                        break;
                    case 'is_verified':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $reviewData[$field] = in_array(strtolower($value), ['yes', '1', 'true']);
                        }
                        break;
                    case 'additional_data':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $reviewData[$field] = is_string($value) ? json_decode($value, true) : $value;
                        }
                        break;
                    case 'verified_at':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $reviewData[$field] = $value ? \Carbon\Carbon::parse($value) : null;
                        }
                        break;
                }
            }
            
            // Only proceed if we have a title, product_id, and user_id
            if (!empty($reviewData['title']) && !empty($reviewData['product_id']) && !empty($reviewData['user_id'])) {
                // Check if review exists by title, product_id, and user_id
                $review = ProductReview::where('title', $reviewData['title'])
                                     ->where('product_id', $reviewData['product_id'])
                                     ->where('user_id', $reviewData['user_id'])
                                     ->first();
                
                if ($review) {
                    // Update existing review
                    $review->update($reviewData);
                } else {
                    // Create new review with UUID
                    $reviewData['uuid'] = (string) Str::uuid();
                    ProductReview::create($reviewData);
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
            'product_id' => 'product',
            'user_id' => 'user',
            'title' => 'title',
            'content' => 'content',
            'rating' => 'rating',
            'is_verified' => 'verified',
            'additional_data' => 'additional_data',
            'verified_at' => 'verified_at',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
        
        return $columnMap[$field] ?? $field;
    }
}
