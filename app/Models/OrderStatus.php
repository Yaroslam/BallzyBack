<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderStatus
 * 
 * @property int $status_id
 * @property string|null $status
 * 
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class OrderStatus extends Model
{
	protected $table = 'Order_status';
	protected $primaryKey = 'status_id';
	public $timestamps = false;

	protected $fillable = [
		'status'
	];

	public function orders()
	{
		return $this->hasMany(Order::class, 'status_id');
	}
}
