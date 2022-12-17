<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * 
 * @property int $brand_id
 * @property string|null $brand_name
 * 
 * @property Collection|Shoe[] $shoes
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $table = 'Brands';
	protected $primaryKey = 'brand_id';
	public $timestamps = false;

	protected $fillable = [
		'brand_name'
	];

	public function shoes()
	{
		return $this->hasMany(Shoe::class, 'brand_id');
	}
}
