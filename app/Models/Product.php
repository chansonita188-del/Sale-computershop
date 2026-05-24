<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'brand', 'model', 'product_type',
        'cpu_brand', 'cpu_model', 'cpu_speed', 'cpu_cores',
        'gpu_brand', 'gpu_model', 'ram_size', 'ram_type',
        'storage', 'storage_type', 'monitor_size', 'monitor_resolution',
        'monitor_refresh_rate', 'details', 'specifications', 'price',
        'stock', 'image_url', 'featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cpu_speed' => 'decimal:2',
        'featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFullSpecsAttribute()
    {
        $specs = [];
        if ($this->cpu_brand && $this->cpu_model) {
            $specs[] = "CPU: {$this->cpu_brand} {$this->cpu_model} ({$this->cpu_speed} GHz, {$this->cpu_cores} Core)";
        }
        if ($this->ram_size) {
            $specs[] = "RAM: {$this->ram_size} {$this->ram_type}";
        }
        if ($this->gpu_model) {
            $specs[] = "GPU: {$this->gpu_model}";
        }
        if ($this->storage) {
            $specs[] = "Storage: {$this->storage} {$this->storage_type}";
        }
        if ($this->monitor_size) {
            $specs[] = "Monitor: {$this->monitor_size} {$this->monitor_resolution} ({$this->monitor_refresh_rate}Hz)";
        }
        return implode(' | ', $specs);
    }
    
    public function isLowStock()
    {
        return $this->stock <= 5;
    }
}