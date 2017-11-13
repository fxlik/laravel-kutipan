<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class QuoteComment extends Model
{

	protected $fillable = [
		'subject', 'user_id', 'quote_id', 'created_at'
	];

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }

    public function quote()
    {
    	return $this->belongsTo('App\Models\Quote');
    }

    public function likes()
    {
        return $this->morphMany('App\Models\Like', 'likeable');
    }

    public function isOwner() {
        if(Auth::guest())
            return false;

        return Auth::user()->id == $this->user->id;
    }
}
