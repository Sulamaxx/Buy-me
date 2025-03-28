<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Admin\Panel\PanelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CouponCodesController extends PanelController
{

    public function __construct()
	{
		$this->middleware('admin');
		
		parent::__construct();
		
	}

    //
    public function index()
    {
        Log::info('controller');
        return view('admin.coupon_codes.index'); 
    }

    public function redirect()
	{
		// The '/admin' route is not to be used as a page, because it breaks the menu's active state.
		return redirect(admin_uri('coupon_codes'));
	}

}
