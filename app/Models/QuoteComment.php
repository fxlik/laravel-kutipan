<?php

namespace App\Models;

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
}
