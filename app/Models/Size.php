<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Size
 * 
 * @property int $size_id
 * @property string|null $size
 * 
 * @property Collection|ShoesSize[] $shoes_sizes
 *
 * @package App\Models
 */
class Size extends Model
{
	protected $table = 'Sizes';
	protected $primaryKey = 'size_id';
	public $timestamps = false;

	protected $fillable = [
		'size'
	];

	public function shoes_sizes()
	{
		return $this->hasMany(ShoesSize::class, 'size_id');
	}
}
