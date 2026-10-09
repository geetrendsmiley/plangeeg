<?php
namespace App\Services;
use App\Models\Order; use Illuminate\Http\Client\PendingRequest; use Illuminate\Support\Facades\Http; use Illuminate\Support\Str; use RuntimeException;
class PaystackService {
  private function client(): PendingRequest { return Http::baseUrl('https://api.paystack.co')->withToken(config('services.paystack.secret'))->acceptJson(); }
  public function initialize(Order $order): array {
    $email=$order->buyer->email; $response=$this->client()->post('/transaction/initialize',['email'=>$email,'amount'=>(string)$order->amount_kobo,'reference'=>'GG-'.Str::upper(Str::random(20)),'callback_url'=>config('services.paystack.callback_url'),'metadata'=>['order_id'=>$order->id]]);
    if(!$response->successful() || !$response->json('status')) throw new RuntimeException($response->json('message','Paystack initialization failed.'));
    return $response->json('data');
  }
  public function verify(string $reference): array { $response=$this->client()->get('/transaction/verify/'.urlencode($reference)); if(!$response->successful() || !$response->json('status')) throw new RuntimeException('Unable to verify payment.'); return $response->json('data'); }
  public function validWebhook(string $payload,string $signature): bool { $secret=(string)config('services.paystack.secret'); return hash_equals(hash_hmac('sha512',$payload,$secret),$signature); }
}
