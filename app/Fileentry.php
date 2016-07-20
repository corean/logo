<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Fileentry
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $board_id
 * @property string $original_name
 * @property string $file_name
 * @property integer $file_size
 * @property string $file_type
 * @property integer $hit
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @property-read \App\Board $board
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereBoardId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereOriginalName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereFileType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereHit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Fileentry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
