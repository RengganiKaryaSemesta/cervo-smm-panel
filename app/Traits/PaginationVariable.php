<?php 
namespace App\Traits;

trait PaginationVariable
{
        public $pagination = [
                'limit' => null,
                'search' => '',
            ];
        public function __construct()
        {
            $this->pagination['limit'] = config('custom.PAGINATION_LIMIT', 10);
        }
}
