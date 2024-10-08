<?php

namespace App\Http\Controllers\Driver;



class SearchController extends DriverBaseController
{
    public $view_path = "search";
    public $base_route = "search";
    public $title = "Search";

    public function index()
    {
        return view(parent::__loadView('index'));
    }
}
