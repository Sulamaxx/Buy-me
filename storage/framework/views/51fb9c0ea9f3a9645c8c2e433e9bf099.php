<?php
	$thread ??= [];
?>
<div class="list-group-item<?php echo e(data_get($thread, 'p_is_unread') ? '' : ' seen'); ?>">
	<div class="form-check">
		<div class="custom-control ps-0">
			<input type="checkbox" name="entries[]" value="<?php echo e(data_get($thread, 'id')); ?>">
			<label class="control-label" for="entries"></label>
		</div>
	</div>
	
	<a href="<?php echo e(url('account/messages/' . data_get($thread, 'id'))); ?>" class="list-box-user">
		<img src="<?php echo e(url(data_get($thread, 'p_creator.photo_url', ''))); ?>" alt="<?php echo e(data_get($thread, 'p_creator.name')); ?>">
		<span class="name">
			<?php
				$userIsOnline = isUserOnline(data_get($thread, 'p_creator')) ? 'online' : 'offline';
			?>
			<i class="fa fa-circle <?php echo e($userIsOnline); ?>"></i> <?php echo e(str(data_get($thread, 'p_creator.name'))->limit(14)); ?>

		</span>
	</a>
	<a href="<?php echo e(url('account/messages/' . data_get($thread, 'id'))); ?>" class="list-box-content">
		<span class="title"><?php echo e(data_get($thread, 'subject')); ?></span>
		<div class="message-text">
			<?php echo e(str(data_get($thread, 'latest_message.body') ?? '')->limit(125)); ?>

		</div>
		<div class="time text-muted"><?php echo e(data_get($thread, 'created_at_formatted')); ?></div>
	</a>
	
	<div class="list-box-action">
		<?php if(data_get($thread, 'p_is_important')): ?>
			<a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/actions?type=markAsNotImportant')); ?>"
			   data-bs-toggle="tooltip"
			   data-bs-placement="top"
			   class="markAsNotImportant"
			   title="<?php echo e(t('Mark as not important')); ?>"
			>
				<i class="fas fa-star"></i>
			</a>
		<?php else: ?>
			<a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/actions?type=markAsImportant')); ?>"
			   data-bs-toggle="tooltip"
			   data-bs-placement="top"
			   class="markAsImportant"
			   title="<?php echo e(t('Mark as important')); ?>"
			>
				<i class="far fa-star"></i>
			</a>
		<?php endif; ?>
		<a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/delete')); ?>"
		   data-bs-toggle="tooltip"
		   data-bs-placement="top"
		   title="<?php echo e(t('Delete')); ?>"
		>
			<i class="fas fa-trash"></i>
		</a>
		<?php if(data_get($thread, 'p_is_unread')): ?>
			<a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/actions?type=markAsRead')); ?>"
			   class="markAsRead"
			   data-bs-toggle="tooltip"
			   data-bs-placement="top"
			   title="<?php echo e(t('Mark as read')); ?>"
			>
				<i class="fas fa-envelope"></i>
			</a>
		<?php else: ?>
			<a href="<?php echo e(url('account/messages/' . data_get($thread, 'id') . '/actions?type=markAsUnread')); ?>"
			   class="markAsRead"
			   data-bs-toggle="tooltip"
			   data-bs-placement="top"
			   title="<?php echo e(t('Mark as unread')); ?>"
			>
				<i class="fas fa-envelope-open"></i>
			</a>
		<?php endif; ?>
	</div>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/threads/thread.blade.php ENDPATH**/ ?>