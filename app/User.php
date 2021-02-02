<?php

namespace App;

use \Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this-hasMany(Post::class);
    }

    public function comments()
    {
        return $this-hasMany(Comment::class);
    }


    //добавление пользователя
    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->save();

        return $user;
    }

    //изменение пользователя
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }
    //создание/изменение пароля
    public function generatePassword($password)
    {
        if ($password != null) {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    //удаление пользователя
    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }

    //загрузить аватар
    public function uploadAvatar($image)
    {
        //удалить старый аватар, если он есть
        if($image == null) { return; }

        $this->removeAvatar();

        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->avatar = $filename;
        $this->save();
    }  

    public function removeAvatar()
    {
        if($this->avatar != null)
        {
            Storage::delete('uploads/' . $this->avatar);
        }
    }

    // получить аватар, если аватара нет, то выводит дефолтную
    public function getImage()
    {
        if ($this->avatar == null) {
            return '/img/no-image.png';
        }
        return '/uploads/'.$this->avatar;
    }

    //права админа
    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }

    //забрать права админа
    public function makeNormal()
    {
        $this->is_admin = 0;
        $this->save();
    }

    // права админа(переключатель)
    public function toggleAdmin($value) 
    {
        if ($value == null) {
            return $this->makeNormal();
        }
        return $this->makeAdmin();
    }

    //забанить
    public function ban()
    {
        $this->status = 1;
        $this->save();
    }

    //разбанить
    public function unban()
    {
        $this->status = 0;
        $this->save();
    }

    //бан(переключатель)
    public function toggleBan($value) 
    {
        if ($value == null) {
            return $this->unban();
        }
        return $this->ban();
    }
}
