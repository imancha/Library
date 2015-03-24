<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'borrows';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['member_id','book_id','tanggal','tersedia'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at','updated_at'];

	protected $guarded = ['id'];

	public function member()
	{
		return $this->belongsTo('App\Model\Member','member_id','id');
	}

	public function book()
	{
		return $this->belongsTo('App\Model\Book','book_id','id');
	}

}
