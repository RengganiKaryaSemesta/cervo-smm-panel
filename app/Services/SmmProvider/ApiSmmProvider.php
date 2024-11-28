<?php
namespace App\Services\SmmProvider;

use App\Services\SmmProvider\DTOs\DTOSmmProviderBalance;
use App\Services\SmmProvider\DTOs\DTOSmmProviderService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\SmmProvider\Contracts\SmmProviderInterface;

class ApiSmmProvider implements SmmProviderInterface
{
        /** API URL */
        public $api_url = '';

        /** Your API key */
        public $api_key = '';
        public function __construct($api_url, $api_key)
        {
                $this->api_key = $api_key;
                $this->api_url = $api_url;
        }

        /** Add order */
        public function order($data) : Collection
        {
                $post = array_merge(
                        [
                                'key'    => $this->api_key,
                                'action' => 'add',
                        ],
                        $data
                );
                return $this->sendRequest($post);
        }

        /** Get order status  */
        public function status($order_id) : Collection
        {
                return $this->sendRequest(
                        [
                                'key'    => $this->api_key,
                                'action' => 'status',
                                'order'  => $order_id,
                        ]
                );
        }

        /** Get orders status */
        public function multiStatus($order_ids)
        {
                return json_decode(
                        $this->sendRequest(
                                [
                                        'key'    => $this->api_key,
                                        'action' => 'status',
                                        'orders' => implode(
                                                ",",
                                                (array) $order_ids
                                        ),
                                ]
                        )
                );
        }

        /** Get services */
        public function services() : Collection
        {
                $response = $this->sendRequest(
                        [
                                'action' => 'services',
                        ]
                );

                return collect(
                        array_map(
                                fn ($service) => DTOSmmProviderService::fromArray($service),
                                $response
                        )
                );
        }

        /** Refill order */
        public function refill(int $orderId)
        {
                return json_decode(
                        $this->sendRequest(
                                [
                                        'key'    => $this->api_key,
                                        'action' => 'refill',
                                        'order'  => $orderId,
                                ]
                        )
                );
        }

        /** Refill orders */
        public function multiRefill(array $orderIds)
        {
                return json_decode(
                        $this->sendRequest(
                                [
                                        'key'    => $this->api_key,
                                        'action' => 'refill',
                                        'orders' => implode(
                                                ',',
                                                $orderIds
                                        ),
                                ]
                        ),
                        true,
                );
        }

        /** Get refill status */
        public function refillStatus(int $refillId)
        {
                return json_decode(
                        $this->sendRequest(
                                [
                                        'key'    => $this->api_key,
                                        'action' => 'refill_status',
                                        'refill' => $refillId,
                                ]
                        )
                );
        }

        /** Get refill statuses */
        public function multiRefillStatus(array $refillIds)
        {
                return json_decode(
                        $this->sendRequest(
                                [
                                        'key'     => $this->api_key,
                                        'action'  => 'refill_status',
                                        'refills' => implode(
                                                ',',
                                                $refillIds
                                        ),
                                ]
                        ),
                        true,
                );
        }

        /** Cancel orders */
        public function cancel(array $orderIds)
        {
                return json_decode(
                        $this->sendRequest(
                                [
                                        'key'    => $this->api_key,
                                        'action' => 'cancel',
                                        'orders' => implode(
                                                ',',
                                                $orderIds
                                        ),
                                ]
                        ),
                        true,
                );
        }

        /** Get balance */
        public function balance() : DTOSmmProviderBalance
        {
                $result = $this->sendRequest(
                        [
                                'key'    => $this->api_key,
                                'action' => 'balance',
                        ]
                );

                return DTOSmmProviderBalance::fromArray($result);
        }

        private function sendRequest($data) : array
        {
                try {
                        $response = Http::post(
                                $this->api_url,
                                [
                                        'key' => $this->api_key,
                                ] + $data
                        );

                        if ($response->successful()) {
                                return $response->json();
                        }

                        return throw new \Exception("Failed API request: " . $response->body());
                }
                catch (\Throwable $e) {
                        \Log::error($e->getMessage());
                        throw new \Exception("Error communicating with API.");
                }
        }
}
