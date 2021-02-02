<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    use Sluggable;

    protected $fillable = ['title','text'];

    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    public function disallow()
    {
        $this->status = 0;
        $this->save();
    }

    public function toggleAdmin() 
    {
        if ($this->status == 0) {
            return $this->allow();
        }
        return $this->disallow();
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function add($fields)
    {
        $page = new static;
        $page->fill($fields);
        $page->save();

        return $page;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove() {
        $this->delete();
    }
}
