<?php

namespace App\Imports;

use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RoleImport implements ToCollection, WithHeadingRow
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
            $roleData = [];
            
            // Map fields from Excel to model
            foreach ($this->fields as $field) {
                switch ($field) {
                    case 'name':
                    case 'description':
                        if (isset($row[$this->getColumnName($field)])) {
                            $roleData[$field] = $row[$this->getColumnName($field)];
                        }
                        break;
                    case 'is_active':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $roleData[$field] = in_array(strtolower($value), ['yes', '1', 'true']);
                        }
                        break;
                    case 'permissions':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $roleData[$field] = is_string($value) ? json_decode($value, true) : $value;
                        }
                        break;
                    case 'last_used_at':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $roleData[$field] = $value ? \Carbon\Carbon::parse($value) : null;
                        }
                        break;
                }
            }
            
            // Only proceed if we have a name
            if (!empty($roleData['name'])) {
                // Check if role exists by name
                $role = Role::where('name', $roleData['name'])->first();
                
                if ($role) {
                    // Update existing role
                    $role->update($roleData);
                } else {
                    // Create new role with UUID
                    $roleData['uuid'] = (string) Str::uuid();
                    Role::create($roleData);
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
            'permissions' => 'permissions',
            'last_used_at' => 'last_used_at',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
        
        return $columnMap[$field] ?? $field;
    }
}
