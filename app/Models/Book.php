<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Favorites;

class Book extends Model
{
    use Favorites;

    const PBOOK = 'PBook';
    const EBOOK = 'EBook';

    protected $guarded = [];

    // protected $appends = ['is_favorited'];

    public function path()
    {
        return "/books/{$this->category->slug}/$this->id";
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function trending($num, $where){
        $hots = $this->with('onwer', 'category')->latest('views_count')->take($num);
        if ($where) {
            $hots->where($where);
        }
        return $hots->get();
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getCoverAttribute($cover)
    {
        return strpos($cover, 'http') !== false ? $cover : \Storage::url($cover);
    }

    public function setImagesAttribute($images)
    {
        return $this->attributes['images'] = json_encode($images);
    }

    public function getImagesAttribute($images)
    {
        return array_map(function ($item) {
            return strpos($item, 'http') !== false ? $item : \Storage::url($item);
        }, json_decode($images, true));
    }

    public function setKeywordsAttribute($keywords)
    {
        return $this->attributes['keywords'] = json_encode($keywords);
    }

    public function getKeywordsAttribute($keywords)
    {
        return json_decode($keywords, true);
    }

    public function hasAnnex()
    {
        return $this->type == self::EBOOK;
    }

    public function pdfPath()
    {
        return "books/annex/book{$this->id}.pdf";
    }

    public function realPath()
    {
        return public_path() . "/storage/" . $this->pdfPath();
    }

    public function downloadFileName()
    {
        return "{$this->title}-{$this->author}.pdf";
    }
}
