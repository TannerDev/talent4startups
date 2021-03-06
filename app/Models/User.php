<?php

namespace App\Models;

use Cmgmyr\Messenger\Traits\Messagable;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, Messagable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password', 'type'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * The user's profile
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function profile()
	{
		return $this->hasOne('App\Models\Profile');
	}

	/**
	 * The user's projects
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function startups()
	{
		return $this->hasMany('App\Models\Startup');
	}

	/**
	 * The projects the user contributes to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function contributions()
	{
		return $this->belongsToMany('App\Models\Startup');
	}

	/**
	 * Hash the password
	 *
	 * @param $password
	 */
	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = Hash::make($password);
	}

	/**
	 * Register a new user
	 *
	 * @param $username
	 * @param $email
	 * @param $password
	 * @param $type
	 *
	 * @return static
	 */
	public static function register($username, $email, $password, $type)
	{
		$user = new static(compact('username', 'email', 'password', 'type'));

//		$user->raise(new UserRegistered($user));

		return $user;
	}

	public function ratings()
	{
		return $this->morphMany('App\Models\Rating', 'rated');
	}

	public function rating()
	{
		$total_ratings = $score = 0;

		foreach ($this->ratings as $rating) {
			$score = $score + $rating->rating;
			$total_ratings++;
		}

		return $total_ratings > 0 ? round(($score / $total_ratings) * 2, 0, PHP_ROUND_HALF_UP) / 2 : 0;
	}

	/**
	 * Validates that a user has properly completed all the required items for the profile.
	 *
	 * @return bool
	 */
	public function profileIsIncomplete()
	{
		if (is_null($this->profile)) {
			return true;
		}

		if (trim($this->profile->first_name) == '') {
			return true;
		}

		if (trim($this->profile->last_name) == '') {
			return true;
		}

		if (is_null($this->profile->skill) or $this->profile->skill_id == 0) {
			return true;
		}

		return false;
	}

}
