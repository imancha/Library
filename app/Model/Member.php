<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'members';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['nama','tanggal_lahir','jenis_kelamin','jenis_anggota','phone','alamat','keterangan'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['created_at','updated_at'];

	protected $guarded = ['id'];

	public function borrow()
	{
		return $this->hasMany('App\Model\Borrow','member_id','id');
	}

}
