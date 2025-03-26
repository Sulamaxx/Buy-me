<?php
	$stats ??= [];
	$countThreadsWithNewMessage = (int)data_get($stats, 'threads.withNewMessage');
?>
<div class="col-md-3 col-lg-2">
	<ul class="nav nav-pills inbox-nav">
		<li class="nav-item<?php echo e((!request()->has('filter') || request()->query('filter')=='') ? ' active' : ''); ?>">
			<a class="nav-link" href="<?php echo e(url('account/messages')); ?>">
				<?php echo e(t('inbox')); ?>

				<?php
					$badgeColor = (!request()->has('filter') || request()->query('filter')=='') ? 'bg-light' : 'bg-primary text-white';
					$visibility = ($countThreadsWithNewMessage <= 0) ? ' hide' : '';
				?>
				<span class="count-threads-with-new-messages count badge <?php echo e($badgeColor); ?><?php echo e($visibility); ?>">
					<?php echo e(\App\Helpers\Number::short($countThreadsWithNewMessage)); ?>

				</span>
			</a>
		</li>
		<li class="nav-item<?php echo e((request()->query('filter')=='unread') ? ' active' : ''); ?>">
			<a class="nav-link" href="<?php echo e(url('account/messages?filter=unread')); ?>">
				<?php echo e(t('unread')); ?>

			</a>
		</li>
		<li class="nav-item<?php echo e((request()->query('filter')=='started') ? ' active' : ''); ?>">
			<a class="nav-link" href="<?php echo e(url('account/messages?filter=started')); ?>">
				<?php echo e(t('started')); ?>

			</a>
		</li>
		<li class="nav-item<?php echo e((request()->query('filter')=='important') ? ' active' : ''); ?>">
			<a class="nav-link" href="<?php echo e(url('account/messages?filter=important')); ?>">
				<?php echo e(t('important')); ?>

			</a>
		</li>
	</ul>
</div>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/account/messenger/partials/sidebar.blade.php ENDPATH**/ ?>