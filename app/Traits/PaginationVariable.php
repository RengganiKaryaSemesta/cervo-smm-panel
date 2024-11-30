<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Url;

trait PaginationVariable
{
    #[Url]
    public $pagination = [
        "limit"              => NULL,
        "search"             => "",
        "selectAll"          => FALSE,
        "selecteds"          => [],
        "filters_by_deleted" => NULL,
        "order"             => [],
    ];
    public function __construct()
    {
        $this->pagination["limit"] = config(
            "custom.PAGINATION_LIMIT",
            10
        );
    }
    public function updatedPaginationSelectAll($data)
    {
        $model                         = $this->getData();
        $ids                           = $model->get()->pluck("id")->toArray();
        $this->pagination["selecteds"] = $data ? $ids : [];
    }
}
