<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = [
        'images',
        'book_id'
    ];
    /**
     *  
     * @return BelongsTo<Book, Image>
     */
    public function books(): BelongsTo {
        return $this->belongsTo(Book::class);
    }
}
