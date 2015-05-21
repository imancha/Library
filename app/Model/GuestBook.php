<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'guest_books';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nama','email','komentar','waktu'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	protected $guarded = ['id'];

}
