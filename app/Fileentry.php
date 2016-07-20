<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fileentry extends Model
{
    protected $table = 'files';
    protected $fillable = [
        'original_name','file_name', 'file_size', 'file_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
