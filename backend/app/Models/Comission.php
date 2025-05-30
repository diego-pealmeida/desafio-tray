<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $order_id
 * @property float $percentage
 * @property float $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission wherePercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comission whereValue($value)
 * @mixin \Eloquent
 */
class Comission extends Model
{
    protected $casts = [
        'percentage'    => 'float',
        'value'         => 'float',
        'created_at'    => 'date:Y-m-d H:i:s',
        'updated_at'    => 'date:Y-m-d H:i:s'
    ];

    protected $fillable = ['order_id', 'percentage', 'value'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
