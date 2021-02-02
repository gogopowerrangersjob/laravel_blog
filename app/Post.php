<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;

    protected $fillable = ['title','content','date','description'];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function author()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getComments()
    {
        return $this->comments()->where('status', 1)->get();
    }

    public function tags()
    {
    	return $this->belongsToMany(
    		Tag::class,
    		'post_tags',
    		'post_id',
    		'tag_id'
    	);
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    //добавить пост
    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = Auth::user()->id;
        $post->save();

        return $post;
    }

    //изменить пост
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    //удалить пост
    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    //загрузить картинку
    public function uploadImage($image)
    {
        //удалить старую картинку, если она есть
        if ($image == null) {return;}
        $this->removeImage();
        $filename = str_random(10).'.'.$image->extension();
        $image->storeAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }   

    public function removeImage() {
        if ($this->image != null) {
            Storage::delete('uploads/' . $this->image);
        }
    }
    // получить картинку, если картинки нет, то выводит дефолтную
    public function getImage()
    {
        if ($this->image == null) {
            return '/img/no-image.png';
        }
        return '/uploads/'.$this->image;
    }

    //привязка поста к категории
    public function setCategory($id)
    {
         if ($id == null) {return;}
         $this->category_id = $id;
         $this->save();
    }

    //привязка поста к тегам
    public function setTags($ids)
    {
        if ($ids == null) {return;}
        $this->tags()->sync($ids);
    }

    //снятие с публикации
    public function setDraft()
    {
        $this->status = 0;
        $this->save();
    }

    //публикация статьи
    public function setPublic()
    {
        $this->status = 1;
        $this->save();
    }

    //публикация статьи(переключатель)
    public function toggleStatus($value)
    {
        if ($value == null) {
            return $this->setDraft();
        }else {
            return $this->setPublic();
        }
    }

    //добавить пост в рекомендуемое
    public function setFeatured()
    {
        $this->is_featured = 1;
        $this->save();
    }

    //удалить пост из рекомендуемого
    public function setStandart()
    {
        $this->is_featured = 0;
        $this->save();
    }

    //добавить пост в рекомендуемое(переключатель)
    public function toggleFeatured($value)
    {
        if ($value == null) {
            return $this->setStandart();
        }else {
            return $this->setFeatured();
        }
    }

    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
        return $date;
    }

    public function getCategoryTitle(){
        if ($this->category != null) {
            return $this->category->title;
        }
        return 'Нет категории';
    }

    public function getTagsTitle() {
        if (!$this->tags->isEmpty()) {
            return implode(', ', $this->tags->pluck('title')->all());
        }
        return 'Нет тегов';
    }
    public function getCategoryID() {
        return $this->category != null ? $this->category->id : null;
    }

    public function getDate() {
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }

    //поиск предыдущего поста
    public function hasPrev()
    {
        return self::where('id', '<', $this->id)->max('id');
    }

    //получение предыдущего поста
    public function getPrev() {
        $postID = $this->hasPrev();
        return self::find($postID);
    }

    //поиск следующего поста
    public function hasNext()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    //получение следующего поста
    public function getNext() {
        $postID = $this->hasNext();
        return self::find($postID);
    }

    public function related() {
        return self::all()->except($this->id);
    }

    public function hasCategory() {
        if ($this->category != null) {
            return true;
        }
        return false;
    }
    public static function getPopularPosts() {
        return self::orderBy('views','desc')->take(3)->get();
    }
    public static function getFeatuerdPosts() {
        return self::where('is_featured', 1)->take(3)->get();
    }
    public static function getRecentPosts() {
        return self::orderBy('date', 'desc')->take(4)->get();
    }
}
