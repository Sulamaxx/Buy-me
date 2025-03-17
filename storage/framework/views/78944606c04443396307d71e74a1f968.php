<?php
	$countries ??= collect();
	$showCountryFlagNextLang = (config('settings.localization.show_country_flag') == 'in_next_lang');
	
	$showCountrySpokenLang = config('settings.localization.show_country_spoken_languages');
	$showCountrySpokenLang = str_starts_with($showCountrySpokenLang, 'active');
	$supportedLanguages = $showCountrySpokenLang ? getCountrySpokenLanguages() : getSupportedLanguages();
	
	$supportedLanguagesExist = (is_array($supportedLanguages) && count($supportedLanguages) > 1);
	$isLangOrCountryCanBeSelected = ($supportedLanguagesExist || $showCountryFlagNextLang);
	
	// Check if the Multi-Countries selection is enabled
	$multiCountryIsEnabled = false;
	$multiCountryLabel = '';
	if ($showCountryFlagNextLang) {
		if (!empty(config('country.code'))) {
			if ($countries->count() > 1) {
				$multiCountryIsEnabled = true;
			}
		}
	}
	
	$countryName = config('country.name');
	$countryFlag32Url = config('country.flag32_url');
	
	$countryFlagImg = $showCountryFlagNextLang
		? '<img class="flag-icon" src="' . $countryFlag32Url . '" alt="' . $countryName . '">'
		: null;
?>
<?php if($isLangOrCountryCanBeSelected): ?>
	
	<li class="nav-item dropdown lang-menu no-arrow open-on-hover">
		<a href="#" class="dropdown-toggle nav-link pt-1" data-bs-toggle="dropdown" id="langDropdown">
			<?php if(!empty($countryFlagImg)): ?>
				<span>
					<?php echo $countryFlagImg; ?>

					<?php echo e(strtoupper(config('app.locale'))); ?>

				</span>
			<?php else: ?>
				<span><i class="bi bi-globe2"></i></span>
				<i class="bi bi-chevron-down"></i>
			<?php endif; ?>
		</a>
		<ul id="langDropdownItems"
			class="dropdown-menu dropdown-menu-end user-menu shadow-sm"
			role="menu"
			aria-labelledby="langDropdown"
		>
			<?php if($supportedLanguagesExist): ?>
				<li class="px-3 pt-2 pb-3">
					<?php echo e(t('language')); ?>

				</li>
				<?php $__currentLoopData = $supportedLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langCode => $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
						$langFlag = $lang['flag'] ?? '';
						$langFlagCountry = str_replace('flag-icon-', '', $langFlag);
						$isFlagEnabled = (
							config('settings.localization.show_languages_flags')
							&& !empty(trim($langFlag)) && is_string($langFlag)
						);
						$isActive = (strtolower($langCode) == strtolower(config('app.locale')));
					?>
					<li class="dropdown-item<?php echo e($isActive ? ' active' : ''); ?>">
						<a href="<?php echo e(url('locale/' . $langCode)); ?>"
						   tabindex="-1"
						   rel="alternate"
						   hreflang="<?php echo e($lang['tag'] ?? getLangTag($langCode)); ?>"
						   title="<?php echo e($lang['name']); ?>"
						>
							<?php
								$checkBox = $isActive
											? '<i class="fas fa-dot-circle"></i>'
											: '<i class="far fa-circle"></i>';
								$checkBox .= '&nbsp;';
								
								// $langFlag = '<i class="flag-icon ' . $langFlag . '"></i>';
								$langFlag = '<img src="' . getCountryFlagUrl($langFlagCountry) . '">&nbsp;';
								$langFlag .= '&nbsp;';
								
								$langPrefix = $isFlagEnabled ? $langFlag : $checkBox;
							?>
							<?php echo $langPrefix . $lang['native']; ?>

						</a>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>
			
			<?php if($showCountryFlagNextLang): ?>
				<?php if($multiCountryIsEnabled): ?>
					<li class="dropdown-divider mt-2"></li>
					<?php
						$surfingOn = t('surfing_on', [
							'appName' => config('app.name'),
							'country' => $countryName
						]);
						$changeCountry = t('change_country');
					?>
					<li class="px-3 py-2 text-secondary">
						<?php if(!empty($countryFlagImg)): ?>
							<?php echo $countryFlagImg; ?>

						<?php endif; ?>
						<?php echo e($surfingOn); ?>

					</li>
					<li class="dropdown-item mb-1">
						<a data-bs-toggle="modal"
						   data-bs-target="#selectCountry"
						   class="btn btn-sm btn-default rounded-pill"
						   title="<?php echo e($changeCountry); ?>"
						>
							<?php echo e(str($changeCountry)->limit(25)->toString()); ?>

						</a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		</ul>
	</li>
<?php endif; ?>
<?php /**PATH C:\Users\sjeew\OneDrive\Desktop\Buy me\resources\views/layouts/inc/menu/select-language.blade.php ENDPATH**/ ?>