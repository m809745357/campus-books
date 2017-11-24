<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\Favorites;
use Laravel\Scout\Searchable;
use App\Filters\BookFilters;

class Book extends Model
{
    use Favorites; //, Searchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'body' => $this->body
        ];
    }

    protected $mappingProperties = array(
       'title' => array(
            'type' => 'string',
            'analyzer' => 'ik_max_word'
        ),
       'body' => array(
            'type' => 'string',
            'analyzer' => 'ik_max_word'
        )
    );

    const PBOOK = 'PBook';
    const EBOOK = 'EBook';

    protected $guarded = [];

    protected $appends = ['is_favorited'];

    public function path()
    {
        return "/books/{$this->category->slug}/$this->id";
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder       $query
     * @param  BookFilters $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, BookFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function onwer()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * [bills description]
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class, 'book_id');
    }

    public function trending($num, $where){
        dump($where);
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

    /**
     * 获取头像完整地址
     *
     * @param  [type] $cover [description]
     * @return [type]        [description]
     */
    public function getCoverAttribute($cover)
    {
        return strpos($cover, 'http') !== false ? $cover : config('app.url') . $cover;
    }

    /**
     * 设置图片存储
     *
     * @param [type] $images [description]
     */
    public function setImagesAttribute($images)
    {
        return $this->attributes['images'] = json_encode($images);
    }

    /**
     * 获取图片完整地址
     *
     * @param  [type] $images [description]
     * @return [type]         [description]
     */
    public function getImagesAttribute($images)
    {
        return array_map(function ($item) {
            return strpos($item, 'http') !== false ? $item : config('app.url') . $item;
        }, json_decode($images, true));
    }

    /**
     * 设置关键字存储
     *
     * @param [type] $keywords [description]
     */
    public function setKeywordsAttribute($keywords)
    {
        return $this->attributes['keywords'] = json_encode($keywords);
    }

    /**
     * 获取关键字
     *
     * @param  [type] $keywords [description]
     * @return [type]           [description]
     */
    public function getKeywordsAttribute($keywords)
    {
        return json_decode($keywords, true);
    }
    public function disTags($keywords)
    {
        $str = '<span class="select2 select2-container select2-container--default select2-container--focus select2-container--below" dir="ltr" style="width: 100%;">'
            . ''
            . '<span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">'
            . '<ul class="select2-selection__rendered">';
        foreach ($keywords as $word) {
            $str .= '<li class="select2-selection__choice" title="'. $word .'">'. $word .'</li>';
        }
        $str .= '</ul>'
             . '</span>'
             . '</span>';

        return $str;
    }
    public function getTags($keywords)
    {
        $str = '<span class="select2 select2-container select2-container--default select2-container--focus select2-container--below" dir="ltr" style="width: 100%;">'
            . '<span class="selection">'
            . '<span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1">'
            . '<ul class="select2-selection__rendered">';
        foreach ($keywords as $word) {
            $str .= '<li class="select2-selection__choice" title="'. $word .'">'. $word .'</li>';
        }
        $str .= '</ul>'
             . '</span>'
             .  '</span>'
             .  '<span class="dropdown-wrapper" aria-hidden="true"></span>'
             .  '</span>'
             . '<input type="hidden" name="keywords[]">';

        return $str;
    }

    /**
     * 判断是否有附件
     *
     * @return boolean [description]
     */
    public function hasAnnex()
    {
        return $this->type == self::EBOOK;
    }

    /**
     * 获取pdf路径
     *
     * @return [type] [description]
     */
    public function pdfPath()
    {
        return "books/annex/book{$this->id}.pdf";
    }

    /**
     * 获取真实路径
     *
     * @return [type] [description]
     */
    public function realPath()
    {
        return public_path() . "/storage/" . $this->pdfPath();
    }

    /**
     * [downloadFileName description]
     * @return [type] [description]
     */
    public function downloadFileName()
    {
        return "{$this->title}-{$this->author}.pdf";
    }
}
