<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'filename',
        'path',
        'user_id',
        'status',
        'record_count',
        'format',
        'uuid',
    ];

    /**
     * Get the user that owns the export.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
