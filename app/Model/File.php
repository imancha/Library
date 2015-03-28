<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['book_id','filename','sha1sum'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at','updated_at'];

	protected $guarded = [];

	public function book()
	{
		return $this->belongsTo('App\Model\Book','book_id','id');
	}


}
