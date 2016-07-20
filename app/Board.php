<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Board
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $body
 * @property integer $hit
 * @property integer $vote
 * @property \Illuminate\Database\Eloquent\Collection|\App\Fileentry[] $files
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereHit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereVote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereFiles($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Board whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    public function files()
    {
        return $this->hasMany(Fileentry::class);
    }

    /**
     * 오늘이면 시간만 표시
     * 어제 이전이면 날짜만 표시
     * @return string date
     */
    public function get_short_created_at()
    {
        $created_at = new Carbon($this->created_at);
        if ($created_at > Carbon::today() ) {
            return $created_at->toTimeString();
        } else {
            return $created_at->toDateString();
        }
    }
}
