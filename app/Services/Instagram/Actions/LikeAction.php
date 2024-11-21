<?php
namespace App\Services\Instagram\Actions;

use App\Models\InstagramAccount;
use App\Enums\InstagramServiceType;
use Illuminate\Support\Facades\Http;
use App\Enums\InstagramServiceStatus;
use App\Enums\InstagramServiceItemStatus;
use App\Models\InstagramService as InstagramServiceModel;

class LikeAction
{
        protected $instagramAccount;
        protected $instagramServiceModel;

        public function __construct(InstagramServiceModel $instagramServiceModel, InstagramAccount $instagramAccount)
        {
                $this->instagramServiceModel = $instagramServiceModel;
                $this->instagramAccount      = $instagramAccount;
        }
        public function execute()
        {
                try {
                        $csrfToken = $this->extractCsrfToken();
                        $mediaId   = $this->getMediaId();
                        $this->sendLikeRequest(
                                $mediaId,
                                $csrfToken
                        );
                        $this->instagramServiceModel->instagramServiceItems()->create(
                                [
                                        'instagram_account_id' => $this->instagramAccount->id,
                                        'comment'              => null,
                                        'type'                 => InstagramServiceType::Like->value,
                                        'status'               => InstagramServiceStatus::Completed->value,
                                ]
                        );
                        return true;
                }
                catch (\Throwable $th) {
                        $this->instagramServiceModel->instagramServiceItems()->create(
                                [
                                        'instagram_account_id' => $this->instagramAccount->id,
                                        'comment'              => null,
                                        'type'                 => InstagramServiceType::Like->value,
                                        'status'               => InstagramServiceStatus::Failed->value,
                                        'error_msg'            => $th->getMessage(),
                                ]
                        );
                        return false;
                }
        }
        private function extractCsrfToken() : string
        {
                preg_match(
                        '/csrftoken=(.*?);/',
                        $this->instagramAccount->cookie,
                        $matches
                );
                if (! isset($matches[1])) {
                        $this->instagramAccount->update(['status' => 0]);
                        throw new \Exception("CSRF token tidak ditemukan.");
                }
                return $matches[1];
        }
        public function getMediaId()
        {
                $response        = Http::withHeaders(
                        [
                                'Host'                      => 'www.instagram.com',
                                'User-Agent'                => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/109.0',
                                'Accept'                    => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                                'Accept-Language'           => 'id,en-US;q=0.7,en;q=0.3',
                                'Upgrade-Insecure-Requests' => '1',
                                'Sec-Fetch-Dest'            => 'document',
                                'Sec-Fetch-Mode'            => 'navigate',
                                'Sec-Fetch-Site'            => 'none',
                                'Sec-Fetch-User'            => '?1',
                                'Te'                        => 'trailers',
                                'Cookie'                    => $this->instagramAccount->cookie,
                        ]
                )->get($this->instagramServiceModel->url);
                $media           = $response->body();
                $headers         = $response->headers();
                $setCookieHeader = $headers['set-cookie'] ?? [];
                preg_match(
                        '/instagram:\/\/media\?id=(.*?)" \/>/',
                        $media,
                        $mediaId
                );
                if (! isset($mediaId[1])) {
                        preg_match(
                                '/"postPage_(.*?)",/',
                                $media,
                                $mediaId
                        );
                        if (! isset($mediaId[1])) {
                                return throw new \Exception("Media ID tidak ditemukan.");
                        }
                }
                return $mediaId[1];
        }
        public function sendLikeRequest($mediaId, $csrfToken, )
        {
                $response = Http::withHeaders(
                        [
                                'Host'             => 'www.instagram.com',
                                'User-Agent'       => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/109.0',
                                'Accept'           => '*/*',
                                'Accept-Language'  => 'id,en-US;q=0.7,en;q=0.3',
                                'X-Csrftoken'      => $csrfToken,
                                'X-Instagram-Ajax' => '1012379361',
                                'X-Ig-App-Id'      => '936619743392459',
                                'Content-Type'     => 'application/x-www-form-urlencoded',
                                'X-Requested-With' => 'XMLHttpRequest',
                                'Origin'           => 'https://www.instagram.com',
                                'Referer'          => 'https://www.instagram.com/p/CorrQDiPJBL/?next=%2F',
                                'Sec-Fetch-Dest'   => 'empty',
                                'Sec-Fetch-Mode'   => 'cors',
                                'Sec-Fetch-Site'   => 'same-origin',
                                'Cookie'           => $this->instagramAccount->cookie,
                        ]
                )->withBody(
                                '',
                                'application/x-www-form-urlencoded'
                        )
                        ->post("https://www.instagram.com/api/v1/web/likes/{$mediaId}/like/");
                if (! $response->successful()) {
                        return throw new \Exception("Gagal melakukan like");
                }
        }

}