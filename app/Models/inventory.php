<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'description',
        'size',
        'quantity',
        'image',
        'status',
        'area_id',
        'post_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Define the relationship with the Area model.
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Define the relationship with the Post model.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Boot method for the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Update the status based on quantity before saving the model
        static::saving(function ($inventory) {
            $inventory->status = $inventory->quantity > 0 ? 'Available' : 'Not Available';
        });
    }
}
