<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files';

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['book_id','mime','size','sha1sum'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	protected $primaryKey = 'book_id';

	public function book()
	{
		return $this->belongsTo('App\Model\Book','book_id','id');
	}


}
