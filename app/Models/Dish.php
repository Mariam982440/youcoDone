<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Dish extends Model
{
    protected $fillable = ['menu_id', 'category_id', 'name', 'price', 'photo', 'is_available'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}