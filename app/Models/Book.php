<?php

namespace App\Models;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use SoftDeletes ;
    protected $fillable =[
        'title',
        'body',
        'author_id',
        'category_id',
        'cover'
    ];
    /**
     *
     * @return BelongsTo<Author, Book>
     */
    public function author() : BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
    /**
     *
     * @return BelongsToMany<Category, Book, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class , 'book_category','book_id','category_id');
    }
    /**
     *  
     * @return HasMany<Image, Book>
     */
    public function images(): HasMany{
        return $this->hasMany(Image::class);
    }
}
