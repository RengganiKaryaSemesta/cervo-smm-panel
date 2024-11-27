<?php
namespace App\Services\SmmProvider;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ApiSmmProvider
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
        public function order($data)
        {
                $post = array_merge(
                        [
                                'key'    => $this->api_key,
                                'action' => 'add',
                        ],
                        $data
                );
                return json_decode($this->connect($post));
        }

        /** Get order status  */
        public function status($order_id)
        {
                return json_decode(
                        $this->connect(
                                [
                                        'key'    => $this->api_key,
                                        'action' => 'status',
                                        'order'  => $order_id,
                                ]
                        )
                );
        }

        /** Get orders status */
        public function multiStatus($order_ids)
        {
                return json_decode(
                        $this->connect(
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
                return $this->connect(
                        [
                                'key'    => $this->api_key,
                                'action' => 'services',
                        ]
                );
        }

        /** Refill order */
        public function refill(int $orderId)
        {
                return json_decode(
                        $this->connect(
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
                        $this->connect(
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
                        $this->connect(
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
                        $this->connect(
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
                        $this->connect(
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
        public function balance()
        {
                return json_decode(
                        $this->connect(
                                [
                                        'key'    => $this->api_key,
                                        'action' => 'balance',
                                ]
                        )
                );
        }

        private function connect($data)
        {
                try {
                        $cacheKey = 'api_request_' . md5($this->api_url . json_encode($data));

                        return Cache::remember(
                                $cacheKey,
                                now()->addMinutes(10),
                                function () use ($data) {
                                        $data["key"] = $this->api_key;
                                        $response    = Http::post(
                                                $this->api_url,
                                                $data
                                        );

                                        if ($response->successful()) {
                                                $data       = $response->json();
                                                $collection = collect($data);
                                                return $collection;
                                        }

                                        throw new \Exception(
                                                "API request failed to connect from " . $this->api_url .
                                                " with data: " . json_encode($data)
                                        );
                                }
                        );
                }
                catch (\Throwable $th) {
                        \Log::info($th->getMessage());
                        return collect([]);
                }
        }
}
