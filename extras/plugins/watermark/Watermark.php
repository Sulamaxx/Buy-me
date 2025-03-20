<?php

namespace extras\plugins\watermark;

use App\Helpers\DBTool;
use App\Helpers\Files\Storage\StorageDisk;
use App\Models\Setting;
use App\Helpers\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Prologue\Alerts\Facades\Alert;

class Watermark extends Payment
{
	/**
	 * @param $image
	 * @return null
	 */
	public static function apply($image)
	{
		$disk = StorageDisk::getDisk();
		
		// Get the Watermark filepath from DB
		$watermark = config('settings.watermark.watermark');
		
		// 70% (by default) less than actual images
		$watermarkPercentageReduction = config('settings.watermark.percentage_reduction', 70);
		
		try {
			if (!empty($watermark) && $disk->exists($watermark)) {
				$watermark = Image::make($disk->get($watermark));
				
				// Apply Opacity
				$watermark = $watermark->opacity(config('settings.watermark.opacity', 100));
				
				// Apply Proportional Dimensions
				if ($watermarkPercentageReduction > 0 && $watermarkPercentageReduction <= 99) {
					// Watermark will be $watermarkPercentageReduction less than the actual dimensions of images
					$realWatermarkPercentageReduction = (100 - $watermarkPercentageReduction);
					
					// Get the dimensions to which the watermark will be resized
					$watermarkResizeWidth = ceil($image->width() * ($realWatermarkPercentageReduction / 100));
					$watermarkResizeHeight = ceil($image->height() * ($realWatermarkPercentageReduction / 100));
					
					// Try something magical (before you throw in the towel)
					if ($watermarkResizeWidth >= $watermark->width() || $watermarkResizeHeight >= $watermark->height()) {
						$newImgWidth = ceil($image->width() / 3);
						$newImgHeight = ceil($image->height() / 3);
						
						$watermarkResizeWidth = ceil($newImgWidth * ($realWatermarkPercentageReduction / 100));
						$watermarkResizeHeight = ceil($newImgHeight * ($realWatermarkPercentageReduction / 100));
					}
					
					// If the watermark original dimensions (Width & Height) are greater than the resize dimensions,
					// Resize the watermark
					if ($watermark->width() > $watermarkResizeWidth && $watermark->height() > $watermarkResizeHeight) {
						$watermark->resize($watermarkResizeWidth, $watermarkResizeHeight, function ($constraint) {
							$constraint->aspectRatio();
						});
					}
				}
			}
		} catch (\Throwable $e) {
			dd($e->getMessage());
		}
		
		// Get the Watermark position
		$position = config('settings.watermark.position', config('watermark.position'));
		$positionX = (int)config('settings.watermark.position_x', config('watermark.position_x'));
		$positionY = (int)config('settings.watermark.position_y', config('watermark.position_y'));
		
		if ($position == 'random') {
			$positions = ['top-left', 'top', 'top-right', 'left', 'center', 'right', 'bottom-left', 'bottom', 'bottom-right'];
			shuffle($positions);
			if (isset($positions[0])) {
				$position = $positions[0];
			}
		}
		if ($position == 'top') {
			$positionX = 0;
		}
		if ($position == 'left') {
			$positionY = 0;
		}
		if ($position == 'center') {
			$positionX = 0;
			$positionY = 0;
		}
		if ($position == 'right') {
			$positionY = 0;
		}
		if ($position == 'bottom') {
			$positionX = 0;
		}
		
		// Insert watermark at $position corner with 'position_x' & 'position_y' offset
		try {
			if ($watermark instanceof \Intervention\Image\Image) {
				$image->insert($watermark, $position, $positionX, $positionY);
			} else {
				if (!empty($watermark) && $disk->exists($watermark)) {
					$image->insert($disk->get($watermark), $position, $positionX, $positionY);
				}
			}
		} catch (\Throwable $e) {
			return null;
		}
		
		return $image;
	}
	
	/**
	 * @return array
	 */
	public static function getOptions(): array
	{
		$options = [];
		$setting = Setting::active()->where('key', 'watermark')->first();
		if (!empty($setting)) {
			$options[] = (object)[
				'name'     => custom_mb_ucfirst(trans('admin.settings')),
				'url'      => admin_url('settings/' . $setting->id . '/edit'),
				'btnClass' => 'btn-info',
			];
		}
		
		return $options;
	}
	
	/**
	 * @return bool
	 */
	public static function installed(): bool
	{
		$cacheExpiration = 86400; // Cache for 1 day (60 * 60 * 24)
		
		return cache()->remember('plugins.watermark.installed', $cacheExpiration, function () {
			$setting = Setting::active()->where('key', 'watermark')->first();
			if (!empty($setting)) {
				return File::exists(plugin_path('watermark', 'installed'));
			}
			
			return false;
		});
	}
	
	/**
	 * @return bool
	 */
	public static function install(): bool
	{
		// Remove the plugin entry
		self::uninstall();
		
		try {
			// Check if the plugin folder is writable
			if (!self::pluginFolderIsWritable()) {
				return self::filesPermissionError();
			}
			
			// Create plugin setting
			DB::statement('ALTER TABLE ' . DBTool::table((new Setting())->getTable()) . ' AUTO_INCREMENT = 1;');
			$pluginSetting = [
				'key'         => 'watermark',
				'name'        => 'Watermark',
				//'value'     => null,
				'description' => 'Watermark for Ads Pictures',
				'field'       => null,
				'parent_id'   => 0,
				'lft'         => 32,
				'rgt'         => 33,
				'depth'       => 1,
				'active'      => 1,
			];
			$setting = Setting::create($pluginSetting);
			if (empty($setting)) {
				return false;
			}
			
			// Create plugin Installed file
			File::put(plugin_path('watermark', 'installed'), '');
			
			return true;
		} catch (\Throwable $e) {
			Alert::error($e->getMessage())->flash();
		}
		
		return false;
	}
	
	/**
	 * @return bool
	 */
	public static function uninstall(): bool
	{
		try {
			cache()->forget('plugins.watermark.installed');
		} catch (\Throwable $e) {
		}
		
		try {
			// Check if the plugin folder is writable
			if (!self::pluginFolderIsWritable()) {
				return self::filesPermissionError();
			}
			
			// Remove the plugin setting
			$setting = Setting::where('key', 'watermark')->first();
			if (!empty($setting)) {
				$setting->delete();
			}
			
			// Remove plugin Installed file
			File::delete(plugin_path('watermark', 'installed'));
			
			return true;
		} catch (\Throwable $e) {
			Alert::error($e->getMessage())->flash();
		}
		
		return false;
	}
	
	/**
	 * @return bool
	 */
	private static function pluginFolderIsWritable(): bool
	{
		$pluginPath = plugin_path('watermark');
		
		return (
			file_exists($pluginPath)
			&& is_dir($pluginPath)
			&& is_writable($pluginPath)
			&& get_perms($pluginPath) >= 755
		);
	}
	
	/**
	 * @return false
	 */
	private static function filesPermissionError(): bool
	{
		$systemUrl = admin_url('system');
		$errorMessage = 'To do this action, you have to make sure that the watermark plugin folder has writable permissions.';
		$errorMessage .= ' Click <a href="'.$systemUrl.'" target="_blank">here</a> to check all the system\'s files permissions.';
		
		Alert::error($errorMessage)->flash();
		
		return false;
	}
}
