<?php
namespace App\Services;
use App\Models\Order; use App\Models\OrderEvent; use Illuminate\Support\Facades\DB; use Illuminate\Validation\ValidationException;
class OrderStateService {
    private array $allowed=[
      'PENDING'=>['AUTHORIZED','CANCELLED'], 'AUTHORIZED'=>['IN_PROGRESS','CANCELLED'], 'IN_PROGRESS'=>['DELIVERED','DISPUTED'],
      'DELIVERED'=>['HELD','DISPUTED','CANCELLED'], 'HELD'=>['RELEASED','DISPUTED','REFUNDED'], 'DISPUTED'=>['RELEASED','REFUNDED'],
      'RELEASED'=>[], 'REFUNDED'=>[], 'CANCELLED'=>[], 'AUTO_RELEASED'=>[],
    ];
    public function transition(Order $order,string $to,?string $actorId=null,?string $reason=null):Order {
      $from=$order->status; if(!in_array($to,$this->allowed[$from]??[],true)) throw ValidationException::withMessages(['status'=>"Cannot move order from {$from} to {$to}."]);
      return DB::transaction(function() use($order,$from,$to,$actorId,$reason){ $order->update(['status'=>$to]); OrderEvent::create(['order_id'=>$order->id,'from_state'=>$from,'to_state'=>$to,'actor_id'=>$actorId,'reason'=>$reason]); return $order->fresh(); });
    }
}
