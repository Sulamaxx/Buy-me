
<?php
$disabled = '';
if (
	(isset($xPanel) && !$xPanel->hasAccess('delete'))
	or
	(
		/* Security for Admin Users */
		str_contains(\Illuminate\Support\Facades\Route::currentRouteAction(), 'UserController')
		&& (isset($entry) && $entry->can(\App\Models\Permission::getStaffPermissions()))
	)
) {
	$disabled = 'disabled="disabled"';
}
?>
<td class="dt-checkboxes-cell">
	<input name="entryId[]" type="checkbox" value="<?php echo e($entry->{$column['name']}); ?>" class="dt-checkboxes" <?php echo $disabled; ?>>
</td>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/admin/panel/columns/checkbox.blade.php ENDPATH**/ ?>