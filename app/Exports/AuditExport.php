<?php

namespace App\Exports;

use App\Models\Audit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AuditExport implements FromCollection, WithHeadings, WithMapping
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
        return Audit::with('user')->get();
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
                case 'user_id':
                    $headings[] = 'User';
                    break;
                case 'event':
                    $headings[] = 'Event';
                    break;
                case 'auditable_type':
                    $headings[] = 'Model Type';
                    break;
                case 'auditable_id':
                    $headings[] = 'Model ID';
                    break;
                case 'old_values':
                    $headings[] = 'Old Values';
                    break;
                case 'new_values':
                    $headings[] = 'New Values';
                    break;
                case 'url':
                    $headings[] = 'URL';
                    break;
                case 'ip_address':
                    $headings[] = 'IP Address';
                    break;
                case 'user_agent':
                    $headings[] = 'User Agent';
                    break;
                case 'created_at':
                    $headings[] = 'Created At';
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
                    $data[] = $row->id;
                    break;
                case 'user_id':
                    $data[] = $row->user ? $row->user->name : 'System';
                    break;
                case 'event':
                    $data[] = ucfirst($row->event);
                    break;
                case 'auditable_type':
                    $data[] = class_basename($row->auditable_type);
                    break;
                case 'auditable_id':
                    $data[] = $row->auditable_id;
                    break;
                case 'old_values':
                    $data[] = json_encode($row->old_values);
                    break;
                case 'new_values':
                    $data[] = json_encode($row->new_values);
                    break;
                case 'url':
                    $data[] = $row->url;
                    break;
                case 'ip_address':
                    $data[] = $row->ip_address;
                    break;
                case 'user_agent':
                    $data[] = $row->user_agent;
                    break;
                case 'created_at':
                    $data[] = $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : null;
                    break;
            }
        }
        
        return $data;
    }
}
