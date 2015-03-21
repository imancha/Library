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
	protected $fillable = ['id', 'judul', 'edisi', 'jenis', 'tanggal_masuk', 'keterangan'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	protected $guarded = [];

}
