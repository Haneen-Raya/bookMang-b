<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use SoftDeletes ;
    protected $fillable = [
        'name'
    ];
    /**
     *  
     * @return BelongsToMany<Book, Category, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_category', 'category_id', 'book_id');
    }

}
