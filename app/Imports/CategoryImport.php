<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoryImport implements ToCollection, WithHeadingRow
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
            $categoryData = [];
            
            // Map fields from Excel to model
            foreach ($this->fields as $field) {
                switch ($field) {
                    case 'name':
                    case 'description':
                        if (isset($row[$this->getColumnName($field)])) {
                            $categoryData[$field] = $row[$this->getColumnName($field)];
                        }
                        break;
                    case 'is_active':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $categoryData[$field] = in_array(strtolower($value), ['yes', '1', 'true']);
                        }
                        break;
                    case 'metadata':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $categoryData[$field] = is_string($value) ? json_decode($value, true) : $value;
                        }
                        break;
                    case 'published_at':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $categoryData[$field] = $value ? \Carbon\Carbon::parse($value) : null;
                        }
                        break;
                }
            }
            
            // Only proceed if we have a name
            if (!empty($categoryData['name'])) {
                // Check if category exists by name
                $category = Category::where('name', $categoryData['name'])->first();
                
                if ($category) {
                    // Update existing category
                    $category->update($categoryData);
                } else {
                    // Create new category with UUID
                    $categoryData['uuid'] = (string) Str::uuid();
                    Category::create($categoryData);
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
            'name' => 'name',
            'description' => 'description',
            'is_active' => 'active_status',
            'metadata' => 'metadata',
            'published_at' => 'published_at',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
        
        return $columnMap[$field] ?? $field;
    }
}
