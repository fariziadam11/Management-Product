<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow
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
            $userData = [];
            
            // Map fields from Excel to model
            foreach ($this->fields as $field) {
                switch ($field) {
                    case 'name':
                    case 'email':
                        if (isset($row[$this->getColumnName($field)])) {
                            $userData[$field] = $row[$this->getColumnName($field)];
                        }
                        break;
                    case 'role_id':
                        if (isset($row[$this->getColumnName($field)])) {
                            $roleName = $row[$this->getColumnName($field)];
                            $role = Role::where('name', $roleName)->first();
                            if ($role) {
                                $userData[$field] = $role->id;
                            }
                        }
                        break;
                    case 'is_active':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $userData[$field] = in_array(strtolower($value), ['yes', '1', 'true']);
                        }
                        break;
                    case 'preferences':
                        if (isset($row[$this->getColumnName($field)])) {
                            $value = $row[$this->getColumnName($field)];
                            $userData[$field] = is_string($value) ? json_decode($value, true) : $value;
                        }
                        break;
                }
            }
            
            // Only proceed if we have an email
            if (!empty($userData['email'])) {
                // Check if user exists by email
                $user = User::where('email', $userData['email'])->first();
                
                if ($user) {
                    // Update existing user
                    $user->update($userData);
                } else {
                    // Create new user with UUID and a default password
                    $userData['uuid'] = (string) Str::uuid();
                    $userData['password'] = Hash::make('password'); // Default password
                    User::create($userData);
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
            'email' => 'email',
            'role_id' => 'role',
            'is_active' => 'active_status',
            'preferences' => 'preferences',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];
        
        return $columnMap[$field] ?? $field;
    }
}
