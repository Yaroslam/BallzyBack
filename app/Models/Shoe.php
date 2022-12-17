<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Shoe
 *
 * @property int $shoe_id
 * @property int|null $brand_id
 * @property string|null $link
 * @property string|null $img
 * @property int|null $price_euro
 * @property int|null $price_roubles
 *
 * @property Brand|null $brand
 * @property Collection|ShoesSize[] $shoes_sizes
 *
 * @package App\Models
 */
class Shoe extends Model
{
	protected $table = 'Shoes';
	protected $primaryKey = 'shoe_id';
	public $timestamps = false;

	protected $casts = [
		'brand_id' => 'int',
		'price_euro' => 'int',
		'price_roubles' => 'int'
	];

	protected $fillable = [
		'brand_id',
		'link',
		'img',
		'price_euro',
		'price_roubles'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class, 'brand_id');
	}

	public function shoes_sizes()
	{
		return $this->hasMany(ShoesSize::class, 'shoe_id', 'shoe_id');
	}

    public function getShoesBrand($id){
        return Brand::where('brand_id', Shoe::where('shoe_id', $id)->get()->toArray()[0]['brand_id'])->get();
    }

    public function deleteShoesSizes(array $sizes){
        foreach ($sizes as $size){
            foreach ($this->shoes_sizes as $realSizes){
                if($realSizes->size->size == $size){
                    ShoesSize::where('size_hoe_id', $realSizes->id)->delete();
                }
            }
        }
    }
}
