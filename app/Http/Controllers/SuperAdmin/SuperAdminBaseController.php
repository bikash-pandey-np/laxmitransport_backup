<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;


class SuperAdminBaseController extends Controller
{
    public $theme_path = 'superadmin.theme_one.';
    public $view_path = "";
    public $base_route = "";
    public $title = "";

    public function __loadView($view)
    {
        $view = $this->theme_path.'.'.$this->view_path.'.'.$view;
        View::composer($view,function ($view){
            $view->with('theme_path', $this->theme_path);
            $view->with('view_path', $this->theme_path.'.'.$this->view_path.'.');
            $view->with('title', $this->title);
            $view->with('base_route', 'super_admin.'.$this->base_route.'.');
            $view->with('auth', auth('super_admin')->user());
            $view->with('time',format_server_to_local(date('H:i:s')));
        });
        return $view;
    }

    public function imageUploadByThumb($image)
    {
        $this->makeDir();

        $data = getimagesize($image);
        $width = $data[0];
        $height = $data[1];

        $file_name = $image->store('upload','public');
        $image = Image::make(public_path('storage/'.$file_name))->resize(50 * $width/$height,50);
        $image->save('storage/50_50/'.$file_name,60);
        $image = Image::make(public_path('storage/'.$file_name))->resize(300 * $width/$height,300);
        $image->save('storage/300_300/'.$file_name,60);
        $image = Image::make(public_path('storage/'.$file_name))->resize(700 * $width/$height,700);
        $image->save('storage/700_700/'.$file_name,60);
        return $file_name;
    }

    public function unlinkAllImage($image)
    {
        if (isset($image) && file_exists(public_path('storage/'.$image))){
            unlink(public_path('storage/'.$image));
        }

        if (isset($image) && file_exists(public_path('storage/50_50/'.$image))){
            unlink(public_path('storage/50_50/'.$image));
        }

        if (isset($image) && file_exists(public_path('storage/300_300/'.$image))){
            unlink(public_path('storage/300_300/'.$image));
        }

        if (isset($image) && file_exists(public_path('storage/700_700/'.$image))){
            unlink(public_path('storage/700_700/'.$image));
        }
    }

    public function makeDir()
    {
        if (!file_exists(public_path('storage/50_50'))){
            mkdir(public_path('storage/50_50'));
        }

        if (!file_exists(public_path('storage/50_50/upload'))){
            mkdir(public_path('storage/50_50/upload'));
        }

        if (!file_exists(public_path('storage/300_300'))){
            mkdir(public_path('storage/300_300'));
        }

        if (!file_exists(public_path('storage/300_300/upload'))){
            mkdir(public_path('storage/300_300/upload'));
        }

        if (!file_exists(public_path('storage/700_700'))){
            mkdir(public_path('storage/700_700'));
        }

        if (!file_exists(public_path('storage/700_700/upload'))){
            mkdir(public_path('storage/700_700/upload'));
        }

        if (!file_exists(public_path('storage/upload'))){
            mkdir(public_path('storage/upload'));
        }
    }

    public function returnBack($request)
    {
        if ($request->save) {
            return redirect()->route('super_admin.' . $this->base_route . '.index')->with('success', $this->title . ' Create Successful.');
        }
        if ($request->button) {
            return redirect()->route('super_admin.' . $this->base_route . '.index')->with('success', $this->title . ' Create Successful.');
        }
        return redirect()->back()->with('success', $this->title . ' Create Successful.');
    }

    public function returnBackUpdate($request)
    {
        if ($request->save) {
            return redirect()->route('super_admin.' . $this->base_route . '.index')->with('success', $this->title . ' Update Successful.');
        }
        if ($request->button) {
            return redirect()->route('super_admin.' . $this->base_route . '.index')->with('success', $this->title . ' Update Successful.');
        }
        return redirect()->back()->with('success', $this->title . ' Update Successful.');
    }

}
