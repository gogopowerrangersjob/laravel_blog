<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsription extends Model
{
	//добавить рассылку(подписаться)
    public static function add($email)
    {
    	$sub = new static;
        $sub->email = $email;
        $sub->save();

        return $sub;
    }

    public function generateToken() {
        $this->token = str_random(100);
        $this->save();
    }

    //удалить рассылку(отписка)
    public function remove() {
    	$this->delete();
    }
}
