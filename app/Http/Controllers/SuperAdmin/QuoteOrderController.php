<?php
namespace App\Http\Controllers\SuperAdmin;


use App\DataTables\SuperAdmin\QuoteOrderDataTable;

class QuoteOrderController extends SuperAdminBaseController
{
    public $view_path = "quotes";
    public $base_route = "quote";
    public $title = "Quote Order";

    public function index(QuoteOrderDataTable $dataTable)
    {
        return $dataTable->render(parent::__loadView('index'));
    }
}
