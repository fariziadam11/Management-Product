<?php

namespace App\Exports;

use App\Models\ProductReview;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductReviewExport implements FromCollection, WithHeadings, WithMapping
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
        return ProductReview::with(['product', 'user'])->get();
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
                case 'product_id':
                    $headings[] = 'Product';
                    break;
                case 'user_id':
                    $headings[] = 'User';
                    break;
                case 'title':
                    $headings[] = 'Title';
                    break;
                case 'content':
                    $headings[] = 'Content';
                    break;
                case 'rating':
                    $headings[] = 'Rating';
                    break;
                case 'is_verified':
                    $headings[] = 'Verified';
                    break;
                case 'additional_data':
                    $headings[] = 'Additional Data';
                    break;
                case 'attachment':
                    $headings[] = 'Attachment';
                    break;
                case 'verified_at':
                    $headings[] = 'Verified At';
                    break;
                case 'created_at':
                    $headings[] = 'Created At';
                    break;
                case 'updated_at':
                    $headings[] = 'Updated At';
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
                case 'title':
                case 'content':
                case 'rating':
                case 'attachment':
                    $data[] = $row->{$field};
                    break;
                case 'product_id':
                    $data[] = $row->product ? $row->product->name : '';
                    break;
                case 'user_id':
                    $data[] = $row->user ? $row->user->name : '';
                    break;
                case 'is_verified':
                    $data[] = $row->is_verified ? 'Yes' : 'No';
                    break;
                case 'additional_data':
                    $data[] = json_encode($row->additional_data);
                    break;
                case 'verified_at':
                case 'created_at':
                case 'updated_at':
                    $data[] = $row->{$field} ? $row->{$field}->format('Y-m-d H:i:s') : null;
                    break;
            }
        }
        
        return $data;
    }
}
