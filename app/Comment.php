<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function posts()
    {
    	return $this->belongsTo(Post::class);
    }

	public function author()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    //публикация коммантария
    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    //публикация коммантария
    public function disallow()
    {
        $this->status = 0;
        $this->save();
    }

    //публикация коммантария(переключатель)
    public function toggleAdmin() 
    {
        if ($this->status == 0) {
            return $this->allow();
        }
        return $this->disallow();
    }

    //удалить коммент
   	public function remove() {
   		$this->delete();
   	}
}
