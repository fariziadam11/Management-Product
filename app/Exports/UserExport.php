<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
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
        return User::with('role')->get();
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
                case 'name':
                    $headings[] = 'Name';
                    break;
                case 'email':
                    $headings[] = 'Email';
                    break;
                case 'role_id':
                    $headings[] = 'Role';
                    break;
                case 'is_active':
                    $headings[] = 'Active Status';
                    break;
                case 'preferences':
                    $headings[] = 'Preferences';
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
                case 'name':
                case 'email':
                    $data[] = $row->{$field};
                    break;
                case 'role_id':
                    $data[] = $row->role ? $row->role->name : '';
                    break;
                case 'is_active':
                    $data[] = $row->is_active ? 'Yes' : 'No';
                    break;
                case 'preferences':
                    $data[] = json_encode($row->preferences);
                    break;
                case 'created_at':
                case 'updated_at':
                    $data[] = $row->{$field} ? $row->{$field}->format('Y-m-d H:i:s') : null;
                    break;
            }
        }
        
        return $data;
    }
}
