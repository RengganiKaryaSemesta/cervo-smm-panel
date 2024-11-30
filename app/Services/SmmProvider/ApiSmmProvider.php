<?php
namespace App\Services\SmmProvider;

use App\Services\SmmProvider\DTOs\DTOSmmProviderBalance;
use App\Services\SmmProvider\DTOs\DTOSmmProviderService;
use App\Services\SmmProvider\DTOs\DTOSmmProviderStatuses;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Services\SmmProvider\Contracts\SmmProviderInterface;

class ApiSmmProvider implements SmmProviderInterface
{
        /** API URL */
        public $api_url = '';
        public $api_key = '';

        /** Your API key */
        public $secret_key = '';
        public function __construct($api_url, $api_key, $secret_key = NULL)
        {
                $this->api_key    = $api_key;
                $this->api_url    = $api_url;
                $this->secret_key = $secret_key;
        }

        /** Add order */
        public function order($data) : Collection
        {
                return collect($this->sendRequest(['action' => 'add'] + $data));
        }

        /** Get order status  */
        public function status($order_id) : Collection
        {
                return collect(
                        $this->sendRequest(
                                [
                                        'action' => 'status',
                                        'order'  => $order_id,
                                ]
                        )
                );
        }

        /** Get orders status */
        public function multiStatus(array $order_ids) : Collection
        {
                $result       = $this->sendRequest(
                        [
                                'action' => 'status',
                                'orders' => implode(
                                        ",",
                                        (array) $order_ids
                                ),
                        ]
                );
                $filteredData = array_filter(
                        $result,
                        function ($item) {
                                return ! isset($item['error']);
                        }
                );
                return collect(
                        array_map(
                                fn ($status) : DTOSmmProviderStatuses => DTOSmmProviderStatuses::fromArray($status),
                                $filteredData
                        )
                );
        }

        /** Get services */
        public function services() : Collection
        {
                $response     = $this->sendRequest(
                        [
                                'action' => 'services',
                        ]
                );
                $filteredData = array_filter(
                        $response,
                        function ($item) {
                                return stripos(
                                        $item['name'],
                                        'INSTAGRAM'
                                ) !== FALSE;
                        }
                );
                return collect(
                        array_map(
                                fn ($service) => DTOSmmProviderService::fromArray($service),
                                $filteredData
                        )
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
