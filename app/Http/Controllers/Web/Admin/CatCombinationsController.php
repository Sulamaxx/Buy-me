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

namespace App\Http\Controllers\Web\Admin;
use App\Http\Controllers\Web\Public\Auth\Traits\VerificationTrait;
use App\Http\Controllers\Web\Admin\Panel\PanelController;
use App\Models\PostType;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Helpers\Date;
use Illuminate\Support\Carbon;
use App\Http\Requests\Admin\CatCombinationsRequest as StoreRequest;
use App\Http\Requests\Admin\CatCombinationsRequest as UpdateRequest;

class CatCombinationsController extends PanelController
{
	use VerificationTrait;
	
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\CatCombinations');
		$this->xPanel->with([
			'user:id,name',
			
		]);
		$this->xPanel->setRoute(admin_uri('packagescs'));
		$this->xPanel->setEntityNameStrings(trans('admin.catassign'), trans('admin.catassigns'));
//		$this->xPanel->denyAccess(['create']);
		if (!request()->input('order')) {
//			if (config('settings.single.listings_review_activation')) {
//				$this->xPanel->orderBy('reviewed_at');
//			}
			$this->xPanel->orderByDesc('created_at');
		}
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_approval_button', 'bulkApprovalBtn', 'end');
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_disapproval_button', 'bulkDisapprovalBtn', 'end');
//		$this->xPanel->addButtonFromModelFunction('top', 'bulk_deletion_button', 'bulkDeletionButton', 'end');
		
		// Hard Filters
		if (request()->filled('active')) {
			if (request()->query('active') == 0) {
				$this->xPanel->addClause('where', fn ($query) => $query->unverified());
			}
			if (request()->query('active') == 1) {
				$this->xPanel->addClause('where', fn ($query) => $query->verified());
			}
		}
		
		// Filters
		// -----------------------
		$this->xPanel->disableSearchBar();
		// -----------------------
//		$this->xPanel->addFilter(
//			[
//				'name'  => 'id',
//				'type'  => 'text',
//				'label' => 'ID/' . t('reference'),
//			],
//			false,
//			function ($value) {
//				$value = hashId($value, true) ?? $value;
//				$this->xPanel->addClause('where', 'id', '=', $value);
//			}
//		);
		// -----------------------
//		$this->xPanel->addFilter(
//			[
//				'name'  => 'from_to',
//				'type'  => 'date_range',
//				'label' => trans('admin.Date range'),
//			],
//			false,
//			function ($value) {
//				$dates = json_decode($value);
//				if (strlen($dates->from) <= 10) {
//					$dates->from = $dates->from . ' 00:00:00';
//				}
//				if (strlen($dates->to) <= 10) {
//					$dates->to = $dates->to . ' 23:59:59';
//				}
//				$this->xPanel->addClause('where', 'created_at', '>=', $dates->from);
//				$this->xPanel->addClause('where', 'created_at', '<=', $dates->to);
//			}
//		);
//		// -----------------------
//		$this->xPanel->addFilter(
//			[
//				'name'  => 'title',
//				'type'  => 'text',
//				'label' => mb_ucfirst(trans('admin.title')),
//			],
//			false,
//			function ($value) {
//				$this->xPanel->addClause('where', 'title', 'LIKE', "%$value%");
//			}
//		);
//		// -----------------------
//		$this->xPanel->addFilter(
//			[
//				'name'  => 'country',
//				'type'  => 'select2',
//				'label' => mb_ucfirst(trans('admin.country')),
//			],
//			getCountries(),
//			function ($value) {
//				$this->xPanel->addClause('where', 'country_code', '=', $value);
//			}
//		);
//		// -----------------------
//		$this->xPanel->addFilter(
//			[
//				'name'  => 'city',
//				'type'  => 'text',
//				'label' => mb_ucfirst(trans('admin.city')),
//			],
//			false,
//			function ($value) {
//				$this->xPanel->query = $this->xPanel->query->whereHas('city', function ($query) use ($value) {
//					if (is_numeric($value)) {
//						$query->where('id', $value);
//					} else {
//						$query->where('name', 'LIKE', "%$value%");
//					}
//				});
//			}
//		);
//		// -----------------------
//		$this->xPanel->addFilter(
//			[
//				'name'  => 'has_promotion',
//				'type'  => 'dropdown',
//				'label' => trans('admin.has_promotion'),
//			],
//			[
//				'pending' => t('pending'),
//				'onHold'  => t('onHold'),
//				'valid'   => t('valid'),
//				'expired' => t('expired'),
//				// 'canceled' => t('canceled'),
//				// 'refunded' => t('refunded'),
//			],
//			function ($value) {
//				if ($value == 'pending') {
//					$this->xPanel->addClause('whereHas', 'payment', function ($query) {
//						$query->where(function ($query) {
//							$query->valid()->orWhere(fn ($query) => $query->onHold());
//						})->columnIsEmpty('active');
//					});
//				}
//				if ($value == 'onHold') {
//					$this->xPanel->addClause('whereHas', 'payment', function ($query) {
//						$query->onHold()->active();
//					});
//				}
//				if ($value == 'valid') {
//					$this->xPanel->addClause('whereHas', 'payment', function ($query) {
//						$query->valid()->active();
//					});
//				}
//				if ($value == 'expired') {
//					$this->xPanel->addClause('whereHas', 'payment', function ($query) {
//						$query->where(function ($query) {
//							$query->notValid()->where(fn ($query) => $query->columnIsEmpty('active'));
//						})->orWhere(fn ($query) => $query->notValid());
//					});
//				}
//				if ($value == 'canceled') {
//					$this->xPanel->addClause('whereHas', 'payment', fn ($query) => $query->canceled());
//				}
//				if ($value == 'refunded') {
//					$this->xPanel->addClause('whereHas', 'payment', fn ($query) => $query->refunded());
//				}
//			}
//		);
//		// -----------------------
//		if (config('plugins.offlinepayment.installed')) {
//			$this->xPanel->addFilter(
//				[
//					'name'  => 'has_valid_promotion',
//					'type'  => 'dropdown',
//					'label' => trans('admin.has_valid_promotion'),
//				],
//				[
//					'real' => trans('admin.with_real_payment'),
//					'fake' => trans('admin.with_fake_payment'),
//				],
//				function ($value) {
//					if ($value == 'real') {
//						$this->xPanel->addClause('whereHas', 'payment', function ($query) {
//							$query->valid()->active()->notManuallyCreated();
//						});
//					}
//					if ($value == 'fake') {
//						$this->xPanel->addClause('whereHas', 'payment', function ($query) {
//							$query->valid()->active()->manuallyCreated();
//						});
//					}
//				}
//			);
//		}
//		// -----------------------
//		$this->xPanel->addFilter(
//			[
//				'name'  => 'status',
//				'type'  => 'dropdown',
//				'label' => trans('admin.Status'),
//			],
//			[
//				1 => trans('admin.Activated'),
//				2 => trans('admin.Unactivated'),
//			],
//			function ($value) {
//				if ($value == 1) {
//					$this->xPanel->addClause('where', fn ($query) => $query->verified());
//				}
//				if ($value == 2) {
//					$this->xPanel->addClause('where', fn ($query) => $query->unverified());
//				}
//			}
//		);
		
		$isPhoneVerificationEnabled = (config('settings.sms.phone_verification') == 1);
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
//		$this->xPanel->addColumn([
//			'name'      => 'id',
//			'label'     => '',
//			'type'      => 'checkbox',
//			'orderable' => false,
//		]);
        
        $this->xPanel->addColumn([
			'name'          => 'description',
			'label'         => "Name",
			'type'          => 'text',
		]);
		 
        $this->xPanel->addColumn([
			'name'          => 'created_by',
			'label'         => "Created User",
			'type'          => 'model_function',
			'function_name' => 'getCreatedUserNameHtml',
		]);
        
        
        $this->xPanel->addColumn([
			'name'  => 'created_at',
			'label' => "Created Date",
			'type'  => 'datetime',
		]);
        
        $this->xPanel->addColumn([
			'name'          => 'updated_by',
			'label'         => "Modified User",
			'type'          => 'model_function',
			'function_name' => 'getModifiedUserNameHtml',
		]);
//        
//        
        $this->xPanel->addColumn([
			'name'  => 'updated_at',
			'label' => "Modified Date",
			'type'  => 'datetime',
		]);
        
//        
//        $this->xPanel->addColumn([
//			'name'  => 'banner_status',
//			'label' => "Banner Status",
//			'type'  => 'banner_status',
//		]);
//        
//        
//		$i=0;
//        $ShopOwners[$i] ="Please Select A Member!";
//		$old_shops_users = [];
        
		$entity = $this->xPanel->getModel()->find(request()->segment(3));
        
       
		if ($entity!== null)
        {
//            $users = DB::table('users')
//            ->join('payments', 'users.id', '=', 'payments.payable_id')
//            ->where('users.member_shop',1)
//            ->where('payments.payable_type',"App\Models\User")
//            ->where('payments.active',1)
//            ->where('users.id',$entity->user_id)
//            ->select('users.id','users.name')
//            ->get();
        }
        else
        {
//            $activeshops = DB::table('member_shop')->select('user_id')->where('shop_status',1)->get();
//            $ite=0;
//            foreach($activeshops AS $activeshop)
//            {
//                $old_shops_users[$ite] = $activeshop->user_id;
//                $ite++;
//            }
//            $users = DB::table('users')
//            ->join('payments', 'users.id', '=', 'payments.payable_id')
//            ->where('users.member_shop',1)
//            ->where('payments.payable_type',"App\Models\User")
//            ->where('payments.active',1)
//            ->whereNotIn('users.id',$old_shops_users)
//            ->select('users.id','users.name')
//            ->get();
        }
    
        
        
//        $users = DB::table('users')->where('member_shop',1)->get();
//        dd($this);
        
        
        
        
        
        
        
        

//        foreach($users AS $user)
//        {
//            $ShopOwners[$user->id] =  $user->name." - ".$user->id;
//        }
//	
        
        // FIELDS
//        $this->xPanel->addField([
//                'label'       => mb_ucfirst("Member Name"),
//                'name'        => 'user_id',
//                'type'        => 'select2_from_array',
//                'options'     => $ShopOwners,
//                'allows_null' => false,
//            ]); 
        
//        $this->xPanel->addField([
//			'name'       => 'shop_title',
//			'label'      => "Shop Title",
//			'type'       => 'text',
//			'attributes' => [
//				'placeholder' => "Shop Title",
//			],
//		]);
//		$wysiwygEditor = config('settings.single.wysiwyg_editor');
//		$wysiwygEditorViewPath = '/views/admin/panel/fields/' . $wysiwygEditor . '.blade.php';
		
        $this->xPanel->addField([
			'name'       => 'description',
			'label'      => "Package Group Name",
			'type'       => 'text',
			'attributes' => [
//				'placeholder' => "Customer Reference Number",
			],
		]);
        

        
        
        
//        $users = DB::table('categories')->where('active',1)->get();
        $cats = DB::table('categories')->get();

        foreach($cats AS $cat)
        {
            $catoptn[$cat->id] =  $cat->slug;
        }
   
        
        if (!empty($entity)) {
            $testval = $entity->sub_cat_ids;
            $testval123  =  explode(",",$entity->sub_cat_ids);
            
            $this->xPanel->addField([
                'label'       => "Categories",
                'name'        => 'sub_cat_ids[]',
                'type'        => 'select2_from_array',
                'options'     => $catoptn,
                'allows_null' => false,
                'value' => $testval123,
            'attributes' => [
				'multiple' => "multiple",
			],
            ]);
        }
        else
        {
            $this->xPanel->addField([
                'label'       => "Categories",
                'name'        => 'sub_cat_ids[]',
                'type'        => 'select2_from_array',
                'options'     => $catoptn,
                'allows_null' => false,
            'attributes' => [
				'multiple' => "multiple",
			],
            ]);
        }
  
        
        if (!empty($entity)) {
//        $this->xPanel->addField([
//			'name'              => 'banner_status',
//			'label'             => 'Banner Status',
//			'type'              => 'checkbox_switch',
//			'wrapperAttributes' => [
//				'class' => 'col-md-6',
//			],
//		]);
        }

        
		$this->xPanel->addField([
			'name'  => 'empty_line_01empty_line_01',
			'type'  => 'custom_html',
			'value' => '<div style="clear: both;"></div>',
		]);
		
        
        
		if (!empty($entity)) {
            
            
            
			$this->xPanel->addField([
				'name'  => 'empty_line_before_ip',
				'type'  => 'custom_html',
				'value' => '<div style="clear: both;"></div>',
			], 'update');
			
//			$emptyIp = 'N/A';
//			
//			$label = '<span class="fw-bold">' . trans('admin.create_from_ip') . ':</span>';
//			if (!empty($entity->create_from_ip)) {
//				$ipUrl = config('larapen.core.ipLinkBase') . $entity->create_from_ip;
//				$ipLink = '<a href="' . $ipUrl . '" target="_blank">' . $entity->create_from_ip . '</a>';
//			} else {
//				$ipLink = $emptyIp;
//			}
//			$this->xPanel->addField([
//				'name'              => 'create_from_ip',
//				'type'              => 'custom_html',
//				'value'             => '<h5>' . $label . ' ' . $ipLink . '</h5>',
//				'wrapperAttributes' => [
//					'class' => 'col-md-6',
//				],
//			], 'update');
//			
//			$label = '<span class="fw-bold">' . trans('admin.latest_update_ip') . ':</span>';
//			if (!empty($entity->latest_update_ip)) {
//				$ipUrl = config('larapen.core.ipLinkBase') . $entity->latest_update_ip;
//				$ipLink = '<a href="' . $ipUrl . '" target="_blank">' . $entity->latest_update_ip . '</a>';
//			} else {
//				$ipLink = $emptyIp;
//			}
//			$this->xPanel->addField([
//				'name'              => 'latest_update_ip',
//				'type'              => 'custom_html',
//				'value'             => '<h5>' . $label . ' ' . $ipLink . '</h5>',
//				'wrapperAttributes' => [
//					'class' => 'col-md-6',
//				],
//			], 'update');
			
//			$this->xPanel->addField([
//				'name'  => 'empty_line_after_ip',
//				'type'  => 'custom_html',
//				'value' => '<div style="clear: both;"></div>',
//			], 'update');
//			
//			if (!empty($entity->email) || !empty($entity->phone)) {
//				$btnUrl = admin_url('blacklists/add') . '?';
//				$btnQs = (!empty($entity->email)) ? 'email=' . $entity->email : '';
//				$btnQs = (!empty($btnQs)) ? $btnQs . '&' : $btnQs;
//				$btnQs = (!empty($entity->phone)) ? $btnQs . 'phone=' . $entity->phone : $btnQs;
//				$btnUrl = $btnUrl . $btnQs;
//				
//				$btnText = trans('admin.ban_the_user');
//				$btnHint = $btnText;
//				if (!empty($entity->email) && !empty($entity->phone)) {
//					$btnHint = trans('admin.ban_the_user_email_and_phone', ['email' => $entity->email, 'phone' => $entity->phone]);
//				} else {
//					if (!empty($entity->email)) {
//						$btnHint = trans('admin.ban_the_user_email', ['email' => $entity->email]);
//					}
//					if (!empty($entity->phone)) {
//						$btnHint = trans('admin.ban_the_user_phone', ['phone' => $entity->phone]);
//					}
//				}
//				$tooltip = ' data-bs-toggle="tooltip" title="' . $btnHint . '"';
//				
//				$btnLink = '<a href="' . $btnUrl . '" class="btn btn-danger confirm-simple-action"' . $tooltip . '>' . $btnText . '</a>';
//				$this->xPanel->addField([
//					'name'              => 'ban_button',
//					'type'              => 'custom_html',
//					'value'             => $btnLink,
//					'wrapperAttributes' => [
//						'style' => 'text-align:center;',
//					],
//				], 'update');
//			}
		}
        
        
        
        
	}
    
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{  
		return parent::updateCrud();
	}
}
