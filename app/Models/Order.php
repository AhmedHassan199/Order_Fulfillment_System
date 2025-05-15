<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\OrderStates\DraftState;
use App\Services\OrderStates\ApprovedState;
use App\Services\OrderStates\DeliveredState;
use App\Services\OrderStates\CancelledState;
use App\Exceptions\InvalidTransitionException;
use App\Exceptions\ImmutableOrderException;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'status', 'total_amount', 'discount_amount', 'final_amount'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isImmutable(): bool
    {
        return in_array($this->status, ['Delivered', 'Cancelled']);
    }

    public function state()
    {
        switch ($this->status) {
            case 'Approved': return new ApprovedState();
            case 'Delivered': return new DeliveredState();
            case 'Cancelled': return new CancelledState();
            default: return new DraftState();
        }
    }

    public function approve()
    {
        $this->state()->approve($this);
    }

    public function deliver()
    {
        $this->state()->deliver($this);
    }

    public function cancel()
    {
        $this->state()->cancel($this);
    }
}
