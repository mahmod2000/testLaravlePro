<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use Sluggable;

	protected $fillable = ['content','title','image','user_id','enabled','confirm_admin_post'];

	public function user()
	{
		return $this->belongsTo(User::class);
    }

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function sluggable()
	{
		return [
			'slug' => [
				'source' => 'title'
			]
		];
	}

	public function getRouteKeyName()
	{
		return 'slug';
	}

	public function scopeGetConfirmedPosts($query)
	{
		return $query->where('confirm_admin_post',1);
	}
	public function scopeEnabledPost($query)
	{
		return $query->where('enabled',0);
	}
}
