<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * The fields to export.
     *
     * @var array
     */
    protected $fields;

    /**
     * Create a new export instance.
     *
     * @param  array  $fields
     * @return void
     */
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::with('category')->withCount('reviews')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [];
        
        foreach ($this->fields as $field) {
            switch ($field) {
                case 'id':
                    $headings[] = 'ID';
                    break;
                case 'uuid':
                    $headings[] = 'UUID';
                    break;
                case 'category_id':
                    $headings[] = 'Category';
                    break;
                case 'name':
                    $headings[] = 'Name';
                    break;
                case 'description':
                    $headings[] = 'Description';
                    break;
                case 'price':
                    $headings[] = 'Price';
                    break;
                case 'stock':
                    $headings[] = 'Stock';
                    break;
                case 'is_featured':
                    $headings[] = 'Featured';
                    break;
                case 'specifications':
                    $headings[] = 'Specifications';
                    break;
                case 'document':
                    $headings[] = 'Document';
                    break;
                case 'available_from':
                    $headings[] = 'Available From';
                    break;
                case 'created_at':
                    $headings[] = 'Created At';
                    break;
                case 'updated_at':
                    $headings[] = 'Updated At';
                    break;
                case 'reviews_count':
                    $headings[] = 'Reviews Count';
                    break;
            }
        }
        
        return $headings;
    }

    /**
     * @param  mixed  $row
     * @return array
     */
    public function map($row): array
    {
        $data = [];
        
        foreach ($this->fields as $field) {
            switch ($field) {
                case 'id':
                case 'uuid':
                case 'name':
                case 'description':
                case 'price':
                case 'stock':
                case 'document':
                case 'reviews_count':
                    $data[] = $row->{$field};
                    break;
                case 'category_id':
                    $data[] = $row->category ? $row->category->name : '';
                    break;
                case 'is_featured':
                    $data[] = $row->is_featured ? 'Yes' : 'No';
                    break;
                case 'specifications':
                    $data[] = json_encode($row->specifications);
                    break;
                case 'available_from':
                case 'created_at':
                case 'updated_at':
                    $data[] = $row->{$field} ? $row->{$field}->format('Y-m-d H:i:s') : null;
                    break;
            }
        }
        
        return $data;
    }
}
