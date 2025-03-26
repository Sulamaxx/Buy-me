<?php
	$thread ??= [];
	$message ??= [];
?>
<?php if(auth()->id() == data_get($message, 'user.id')): ?>
	<div class="chat-item object-me">
		<div class="chat-item-content">
			<div class="msg">
				<?php echo urls_to_links(nlToBr(data_get($message, 'body')), ['class' => 'text-light']); ?>

				<?php if(!empty(data_get($message, 'filename')) && $disk->exists(data_get($message, 'filename'))): ?>
					<?php
						$mt2Class = !empty(trim(data_get($message, 'body'))) ? 'mt-2' : '';
					?>
					<div class="<?php echo e($mt2Class); ?>">
						<i class="fas fa-paperclip" aria-hidden="true"></i>
						<a class="text-light"
						   href="<?php echo e(privateFileUrl(data_get($message, 'filename'), null)); ?>"
						   target="_blank"
						   data-bs-toggle="tooltip"
						   data-bs-placement="left"
						   title="<?php echo e(basename(data_get($message, 'filename'))); ?>"
						>
							<?php echo e(str(data_get($message, 'filename'))->basename()->limit(20)); ?>

						</a>
					</div>
				<?php endif; ?>
			</div>
			<span class="time-and-date">
				<?php echo e(data_get($message, 'created_at_formatted')); ?>

				<?php
					$recipient = data_get($message, 'p_recipient');
					
					$threadUpdatedAt = new \Illuminate\Support\Carbon(data_get($thread, 'updated_at'));
					$threadUpdatedAt->timezone(\App\Helpers\Date::getAppTimeZone());
					
					$recipientLastRead = new \Illuminate\Support\Carbon(data_get($recipient, 'last_read'));
					$recipientLastRead->timezone(\App\Helpers\Date::getAppTimeZone());
					
					$threadIsUnreadByThisRecipient = (
						!empty($recipient)
						&& (
							data_get($recipient, 'last_read') === null
							|| $threadUpdatedAt->gt($recipientLastRead)
						)
					);
				?>
				<?php if($threadIsUnreadByThisRecipient): ?>
					&nbsp;<i class="fas fa-check-double"></i>
				<?php endif; ?>
			</span>
		</div>
	</div>
<?php else: ?>
	<div class="chat-item object-user">
		<div class="object-user-img">
			<a href="<?php echo e(\App\Helpers\UrlGen::user(data_get($message, 'user'))); ?>">
				<img src="<?php echo e(url(data_get($message, 'user.photo_url'))); ?>" alt="<?php echo e(data_get($message, 'user.name')); ?>">
			</a>
		</div>
		<div class="chat-item-content">
			<div class="chat-item-content-inner">
				<div class="msg bg-white">
					<?php echo urls_to_links(nlToBr(data_get($message, 'body'))); ?>

					<?php if(!empty(data_get($message, 'filename')) && $disk->exists(data_get($message, 'filename'))): ?>
						<?php
							$mt2Class = !empty(trim(data_get($message, 'body'))) ? 'mt-2' : '';
						?>
						<div class="<?php echo e($mt2Class); ?>">
							<i class="fas fa-paperclip" aria-hidden="true"></i>
							<a class=""
							   href="<?php echo e(privateFileUrl(data_get($message, 'filename'), null)); ?>"
							   target="_blank"
							   data-bs-toggle="tooltip"
							   data-bs-placement="left"
							   title="<?php echo e(basename(data_get($message, 'filename'))); ?>"
							>
								<?php echo e(str(data_get($message, 'filename'))->basename()->limit(20)); ?>

							</a>
						</div>
					<?php endif; ?>
				</div>
				<?php
					$userIsOnline = isUserOnline(data_get($message, 'user'));
				?>
				<span class="time-and-date ms-0">
					<?php if($userIsOnline): ?>
						<i class="fa fa-circle color-success"></i>&nbsp;
					<?php endif; ?>
					<?php echo e(data_get($message, 'created_at_formatted')); ?>

				</span>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/messages/message.blade.php ENDPATH**/ ?>