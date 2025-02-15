<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'department_id';
    protected $fillable = ['department_name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
