<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'publishers';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nama'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	protected $guarded = ['id'];

	public function book()
	{
		return $this->hasMany('App\Model\Book', 'publisher_id', 'id');
	}

}
