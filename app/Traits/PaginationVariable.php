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
        "filters_by_deleted" => "not_deleted",
        "order"              => [],
    ];
    public function __construct()
    {
        $this->pagination["limit"] = config(
            "custom.PAGINATION_LIMIT",
            10
        );
    }
    public function updatedPagination($data, $key)
    {
        if ($key != "selectAll" && ! str_contains(
            $key,
            "selecteds")) {
            $this->pagination["selectAll"] = FALSE;
            $this->pagination["selecteds"] = [];
            $this->resetPage();
        }
    }
    public function updatedPaginationSelectAll($data)
    {
        $model                         = $this->getData();
        $ids                           = $model->get()->pluck("id")->toArray();
        $this->pagination["selecteds"] = $data ? $ids : [];
    }
}
