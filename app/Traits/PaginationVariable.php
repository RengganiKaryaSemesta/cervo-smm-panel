<?php
namespace App\Traits;

use Livewire\Attributes\Url;

trait PaginationVariable
{
    #[Url]
    public $pagination = [
        'limit'  => null,
        'search' => '',
    ];
    public function __construct()
    {
        $this->pagination['limit'] = config(
            'custom.PAGINATION_LIMIT',
            10
        );
    }
}
