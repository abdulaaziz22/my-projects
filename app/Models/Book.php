<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'file_path',
        'image',
        'Publisher_id',
        'description',
        'accepted',
        'book_audio', 
        'edition',
        'category_id' 
   ];
   
   public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function Publisher(){
        return $this->belongsTo(Publisher::class);
    }
    /**
     * The Authors that belong to the Book
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class,'author_books');
    }
    

}
