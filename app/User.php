<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\{Role, Profile, Post};

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
				'name',
				'email',
				'surname',
				'password',
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
		'surname' => 'string',
		'name' => 'string'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function is_admin()
	{

		if ($this->role->id === 2)
			return true;
		else
			return false;
	}

	public function profile()
	{
		return $this->hasOne(Profile::class);
	}


	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function createProfile($image)
	{
		$this->profile()->create([
			'user_id' => $this,
			'image_id' => $image->id,
		]);
	}

	public function get_slug_snake(){
		$slug = Str::snake($this->name.' '.$this->surname);
		return $slug;
	}
}
