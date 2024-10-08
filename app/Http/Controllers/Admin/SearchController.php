<?php

namespace App\Http\Controllers\Admin;



class SearchController extends AdminBaseController
{
    public $view_path = "search";
    public $base_route = "search";
    public $title = "Search";

    public function index()
    {
        return view(parent::__loadView('index'));
    }
}
