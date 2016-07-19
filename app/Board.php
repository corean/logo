<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','body', 'files',
    ];


    /**
     * 게시물 만든 유저
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
