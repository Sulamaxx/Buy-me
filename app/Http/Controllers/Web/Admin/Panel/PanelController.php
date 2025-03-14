<?php
/*
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved
 *
 * Website: https://laraclassifier.com
 * Author: BeDigit | https://bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from CodeCanyon,
 * Please read the full License from here - https://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Web\Admin\Panel;

use App\Http\Controllers\Web\Admin\Controller;
use App\Http\Controllers\Web\Admin\Panel\Library\Panel;
use App\Http\Controllers\Web\Admin\Panel\Traits\AjaxTable;
use App\Http\Controllers\Web\Admin\Panel\Traits\BulkActions;
use App\Http\Controllers\Web\Admin\Panel\Traits\Reorder;
use App\Http\Controllers\Web\Admin\Panel\Traits\SaveActions;
use App\Http\Controllers\Web\Admin\Panel\Traits\ShowDetailsRow;
use Prologue\Alerts\Facades\Alert;
use App\Helpers\Date;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

// VALIDATION
use App\Http\Requests\Admin\Request as StoreRequest;
use App\Http\Requests\Admin\Request as UpdateRequest;

class PanelController extends Controller
{
	use AjaxTable, Reorder, ShowDetailsRow, SaveActions, BulkActions;
	
	public $xPanel;
	public $data = [];
	public $request;
	
	public $parentId = 0;
	
	/**
	 * Controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		
		if (!$this->xPanel) {
			$this->xPanel = new Panel();
			
			$this->middleware(function ($request, $next) {
				$this->request = $request;
				$this->xPanel->request = $request;
				$this->setup();
				
				return $next($request);
			});
		}
	}
	
	public function setup()
	{
		// ...
	}
	
	/**
	 * Display all rows in the database for this entity.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$this->xPanel->hasAccessOrFail('list');
		
		$this->data['xPanel'] = $this->xPanel;
		$this->data['title'] = ucfirst($this->xPanel->entityNamePlural);
		
		// get all entries if AJAX is not enabled
		if (!$this->data['xPanel']->ajaxTable) {
			$this->data['entries'] = $this->data['xPanel']->getEntries();
		}
		
		return view('admin.panel.list', $this->data);
	}
	
	/**
	 * Show the form for creating inserting a new row.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create()
	{
		$this->xPanel->hasAccessOrFail('create');
		
		// prepare the fields you need to show
		$this->data['xPanel'] = $this->xPanel;
		$this->data['saveAction'] = $this->getSaveAction();
		$this->data['fields'] = $this->xPanel->getCreateFields();
		$this->data['title'] = trans('admin.add') . ' ' . $this->xPanel->entityName;
		
		return view('admin.panel.create', $this->data);
	}
	
	/**
	 * Store a newly created resource in the database.
	 *
	 * @param UpdateRequest|null $request
	 * @return mixed
	 */
	public function storeCrud(StoreRequest $request = null)
	{
		$this->xPanel->hasAccessOrFail('create');
		
		// fallback to global request instance
		if (is_null($request)) {
			$request = request()->instance();
		}
		
		try {
			// replace empty values with NULL, so that it will work with MySQL strict mode on
			foreach ($request->input() as $key => $value) {
				if (empty($value) && $value !== '0') {
					$request->request->set($key, null);
				}
			}
			
            //shop code start
//            if(($request->shop_banner)==null)
//            {
//               $request['shop_banner'] = config('larapen.core.picture.default');
//                
//            }
//            else
             if( isset($request['shop_details']))   
            {
                $newshoppayment = DB::table('payments')->select('period_end')->where('payable_id',$request['user_id'])->where('payable_type','App\Models\User')->get();
                $request['shop_expire_date']=$newshoppayment[0]->period_end;

//                $currentDate = date('Y-m-d H:i:s');
//                $expireDate=date('Y-m-d H:i:s', strtotime('+1 year', strtotime($currentDate)) );
//                $request['shop_expire_date']=$expireDate;
                
                $authUser = auth('sanctum')->user();
                $request['shop_visits']=0;
                $request['shop_status']=1;
                $request['created_by']=$authUser->id;
//                $today = Carbon::now(Date::getAppTimeZone());
//                $request->request->set('created_at', $today);
                $request->request->set('updated_at', null);
             if($request->shop_banner!=null && (!is_string($request->shop_banner) && null !==($request->shop_banner->hashName())))
               {  
                $filename = 'shop_pics/'.$request->user_id.'.'.$request->shop_banner->extension();
                $request['shop_banner'] = $filename;

                }
                else
                {
                   $request['shop_banner'] = config('larapen.core.picture.default');
                }
                
            }
            //shop code end
            
            
            
            
             //banner code start
             if(isset($request['banner_remarks']))   
            {
                $authUser = auth('sanctum')->user();
                $request['banner_status']=1;
                 $mystring = "";
                 if(is_null($request->banner_pages))
                 {
                     
                 }
                 else
                 {
                     foreach($request->banner_pages as $pagedata)
                     {
                         $mystring.=$pagedata.',';
                     }
                     $mystring = substr($mystring,0,-1);
                     $request['banner_pages']=$mystring;
                 }
                 
                $request['created_by']=$authUser->id;
                $request->request->set('updated_at', null);
             if($request->banner_image!=null && (!is_string($request->banner_image) && null !==($request->banner_image->hashName())))
               {  
                 
                 $lastBanner = DB::table('user_banners')->select('id')->orderBy('id', 'desc')->get();
                 
                 if(count($lastBanner)>0)
                {
                    $requestnextid=($lastBanner[0]->id)+1;
                }
                else
                {
                    $requestnextid=1;
                }
                 
                $filename = 'banner_pics/'.$request->cust_ref_numb.'_'.$request->banner_type.'_'.$request->banner_location.'_'.$requestnextid.'.'.$request->banner_image->extension();
                $request['banner_image'] = $filename;
                }
                else
                {
                   $request['banner_image'] = config('larapen.core.picture.default');
                }
                    $datetime2 = strtotime($request->banner_s_date);
                    $datetime1 = strtotime($request->banner_e_date);
                    $datediff = $datetime1 - $datetime2;
                    $request['banner_d_days'] = round($datediff / (60 * 60 * 24));
            }
            //banner code end
            
            // category assignments code start
            if(isset($request['sub_cat_ids']))   
            {
                $mystring = "";
                
//                print_r($request->sub_cat_ids);
                 foreach($request->sub_cat_ids as $pagedata)
                 {
                     $mystring.=$pagedata.',';
                 }
//                echo('<br>');
//                echo($mystring);
                
                 $mystring = substr($mystring,0,-1);
                 $request['sub_cat_ids']=$mystring;
//                echo('<br>');
//                echo($mystring);
                
                
                $authUser = auth('sanctum')->user();
                $request['created_by']=$authUser->id;
//                $request->request->set('updated_at', null);
            }
            // category assignments code end
            
			// insert item in the db
			$item = $this->xPanel->create($request->except(['redirect_after_save', '_token']));
			
			if (empty($item)) {
				Alert::error(trans('admin.error_saving_entry'))->flash();
				return back();
			}
			
			// show a success message
			Alert::success(trans('admin.insert_success'))->flash();
			
			// save the redirect choice for next time
			$this->setSaveAction();
			
			return $this->performSaveAction($item->getKey());
		} catch (\Throwable $e) {
			// Get error message
			$msg = 'Error found - [' . $e->getCode() . '] : ' . $e->getMessage() . '.';
			
			// Error notification
			Alert::error($msg)->flash();
			
			return redirect()->to($this->xPanel->route);
		}
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $id
	 * @param null $childId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id, $childId = null)
	{
		$this->xPanel->hasAccessOrFail('update');
		
		$entry = null;
		if (!empty($childId)) {
			$entry = $this->xPanel->getEntryWithParentAndChildKeys($id, $childId);
			$id = $childId;
		}
		
		// get the info for that entry
		$this->data['entry'] = (isset($entry) && !empty($entry)) ? $entry : $this->xPanel->getEntry($id);
		$this->data['xPanel'] = $this->xPanel;
		$this->data['saveAction'] = $this->getSaveAction();
		$this->data['fields'] = $this->xPanel->getUpdateFields($id);
		$this->data['title'] = trans('admin.edit') . ' ' . $this->xPanel->entityName;
		
		$this->data['id'] = $id;
		
		return view('admin.panel.edit', $this->data);
	}
	
	/**
	 * Update the specified resource in the database.
	 *
	 * @param UpdateRequest|null $request
	 * @return mixed
	 */
	public function updateCrud(UpdateRequest $request = null)
	{
		$this->xPanel->hasAccessOrFail('update');
		
		// fallback to global request instance
		if (is_null($request)) {
			$request = request()->instance();
		}
		
		try {
			// replace empty values with NULL, so that it will work with MySQL strict mode on
			foreach ($request->input() as $key => $value) {
				if (empty($value) && $value !== 0 && $value !== '0') {
					$request->request->set($key, null);
                    
				}
//                echo($key."->".$value.'<br>');
			}
            $guard = isFromApi() ? 'sanctum' : null;
            $userId = auth($guard)->user()?->getAuthIdentifier() ?? '-1';
//            updated_user_id
            $today = Carbon::now(Date::getAppTimeZone());
            $request->request->set('updated_at', $today);
            $request->request->set('updated_user_id', $userId);
            
            
            if(!is_null($request->reviewed_at))
            {
                $request->request->set('reviewed_user_id', $userId);
            }
            else
            {
                $request->request->set('reviewed_user_id', '');
            }
                
             //shop code start
//            dd($request);
            if(isset($request['shop_details']))
                {
                    $cur_date = date('Y-m-d H:i:s');
                    $request->request->set('updated_at', $cur_date);
                    $request->request->set('updated_by', $userId);
                    if(($request->shop_banner)==null)
                    {
                       $request['shop_banner'] = config('larapen.core.picture.default');
                    }
                    else
                    {
                       if(!is_string($request->shop_banner) && null !==($request->shop_banner->hashName()))
                        {  
                        $filename = 'shop_pics/'.$request->user_id.'.'.$request->shop_banner->extension();
                        $request['shop_banner'] = $filename;
                        }
                        else
                        {
                            $editingshop = DB::table('member_shop')->select('shop_banner')->where('id',$request['id'])->get();
                            $request['shop_banner']=$editingshop[0]->shop_banner;
                        }
                    }
                }
             //shop code end
            
            //banner code start
             if(isset($request['banner_remarks']))   
            {
                 $cur_date = date('Y-m-d H:i:s');
                 $request->request->set('updated_at', $cur_date);
                 $request->request->set('updated_by', $userId);
                 $mystring = "";
                 foreach($request->banner_pages as $pagedata)
                 {
                     $mystring.=$pagedata.',';
                 }
                 $mystring = substr($mystring,0,-1);
                 $request['banner_pages']=$mystring;
                 
                 if(($request->banner_image)==null)
                    {
                       $request['banner_image'] = config('larapen.core.picture.default');
                    }
                    else
                    {
                       if(!is_string($request->banner_image) && null !==($request->banner_image->hashName()))
                        {  
                           $requestnextid = $request['id'];
                        $filename = 'banner_pics/'.$request->cust_ref_numb.'_'.$request->banner_type.'_'.$request->banner_location.'_'.$requestnextid.'.'.$request->banner_image->extension();
                        $request['banner_image'] = $filename;
                        }
                        else
                        {
                            $editingbanner = DB::table('user_banners')->select('banner_image')->where('id',$request['id'])->get();
                            $request['banner_image']=$editingbanner[0]->banner_image;
                        }
                    } 
                    $datetime2 = strtotime($request->banner_s_date);
                    $datetime1 = strtotime($request->banner_e_date);
                    $datediff = $datetime1 - $datetime2;
                    $request['banner_d_days'] = round($datediff / (60 * 60 * 24));
            }
            //banner code end
            
            // category assignments code start
            if(isset($request['sub_cat_ids']))   
            {
              
                $mystring = "";
                 foreach($request->sub_cat_ids as $pagedata)
                 {
                     $mystring.=$pagedata.',';
                 }
                 $mystring = substr($mystring,0,-1);
                 $request['sub_cat_ids']=$mystring;
                 $cur_date = date('Y-m-d H:i:s');
                 $request->request->set('updated_at', $cur_date);
                 $request->request->set('updated_by', $userId);
                
            }
            // category assignments code end
            
			// update the row in the db
			$item = $this->xPanel->update($request->get($this->xPanel->model->getKeyName()), $request->except('redirect_after_save', '_token'));
			
			if (empty($item)) {
				Alert::error(trans('admin.error_saving_entry'))->flash();
				return back();
			}
			
			if (!$item->wasChanged()) {
				Alert::warning(t('observer_nothing_has_changed'))->flash();
				return back()->withInput();
			}
			
			// show a success message
			Alert::success(trans('admin.update_success'))->flash();
			
			// save the redirect choice for next time
			$this->setSaveAction();
			
			return $this->performSaveAction($item->getKey());
		} catch (\Throwable $e) {
			// Get error message
			$msg = 'Error found - [' . $e->getCode() . '] : ' . $e->getMessage() . '.';
			
			// Error notification
			Alert::error($msg)->flash();
			
			return redirect()->to($this->xPanel->route);
		}
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @param null $childId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show($id, $childId = null)
	{
		// @todo: Make the entries details by take account all possible fields
		// return redirect()->to($this->xPanel->route);
		
		$this->xPanel->hasAccessOrFail('show');
		
		$entry = null;
		if (!empty($childId)) {
			$entry = $this->xPanel->getEntryWithParentAndChildKeys($id, $childId);
			$id = $childId;
		}
		
		// get the info for that entry
		$this->data['entry'] = (isset($entry) && !empty($entry)) ? $entry : $this->xPanel->getEntry($id);
		$this->data['xPanel'] = $this->xPanel;
		$this->data['title'] = trans('admin.preview') . ' ' . $this->xPanel->entityName;
		
		return view('admin.panel.show', $this->data);
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $id
	 * @param null $childId
	 * @return mixed
	 */
	public function destroy($id, $childId = null)
	{
		$this->xPanel->hasAccessOrFail('delete');
		
		if (!empty($childId)) {
			$id = $childId;
		}
		
		return $this->xPanel->delete($id);
	}
}
