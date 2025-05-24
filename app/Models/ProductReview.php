<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class ProductReview extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;
    
    /**
     * Review status constants
     */
    const STATUS_IN_REVIEW = 'in_review';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'product_id',
        'user_id',
        'title',
        'content',
        'rating',
        'status',
        'is_verified',
        'additional_data',
        'attachment',
        'verified_at',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uuid' => 'string',
        'rating' => 'integer',
        'is_verified' => 'boolean',
        'additional_data' => 'json',
        'verified_at' => 'datetime',
    ];
    
    /**
     * Get the product that owns the review.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->uuid = (string) \Illuminate\Support\Str::uuid();
            // Set default status to in_review for new reviews
            if (!$model->status) {
                $model->status = self::STATUS_IN_REVIEW;
            }
        });
    }
}
