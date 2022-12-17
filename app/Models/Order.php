<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $order_id
 * @property int|null $size_shoes_id
 * @property string|null $contact_link
 * @property int|null $status_id
 * 
 * @property ShoesSize|null $shoes_size
 * @property OrderStatus|null $order_status
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'Orders';
	protected $primaryKey = 'order_id';
	public $timestamps = false;

	protected $casts = [
		'size_shoes_id' => 'int',
		'status_id' => 'int'
	];

	protected $fillable = [
		'size_shoes_id',
		'contact_link',
		'status_id'
	];

	public function shoes_size()
	{
		return $this->belongsTo(ShoesSize::class, 'size_shoes_id');
	}

	public function order_status()
	{
		return $this->belongsTo(OrderStatus::class, 'status_id');
	}
}
