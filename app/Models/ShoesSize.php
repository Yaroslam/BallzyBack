<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShoesSize
 * 
 * @property int $size_shoes_id
 * @property int|null $shoe_id
 * @property int|null $size_id
 * 
 * @property Size|null $size
 * @property Shoe|null $shoe
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class ShoesSize extends Model
{
	protected $table = 'Shoes_sizes';
	protected $primaryKey = 'size_shoes_id';
	public $timestamps = false;

	protected $casts = [
		'shoe_id' => 'int',
		'size_id' => 'int'
	];

	protected $fillable = [
		'shoe_id',
		'size_id'
	];

	public function size()
	{
		return $this->belongsTo(Size::class, 'size_id');
	}

	public function shoe()
	{
		return $this->belongsTo(Shoe::class, 'shoe_id');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'size_shoes_id');
	}
}
