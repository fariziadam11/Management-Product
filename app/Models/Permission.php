<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // Using standard auto-incrementing IDs
    protected $keyType = 'int';
    public $incrementing = true;
}
