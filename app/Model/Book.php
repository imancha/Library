<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'books';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','judul','edisi','jenis','tanggal_masuk','keterangan','file','publisher_id','subject_id','rack_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at','updated_at'];

	protected $guarded = [];

	public function author()
	{
		return $this->belongsToMany('App\Model\Author','book_authors','book_id','author_id');
	}

	public function publisher()
	{
		return $this->belongsTo('App\Model\Publisher','publisher_id','id');
	}

	public function rack()
	{
		return $this->belongsTo('App\Model\Rack','rack_id','id');
	}

	public function subject()
	{
		return $this->belongsTo('App\Model\Subject','subject_id','id');
	}

	public function borrow()
	{
		return $this->hasMany('App\Model\Borrow','book_id','id');
	}

}
