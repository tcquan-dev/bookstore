@if ($crud->hasAccess('delete', $entry))
<button data-route="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-sm btn-delete btn-link" data-button-type="delete">
	<span><i class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</span>
</button>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
	$(document).on("click", ".btn-delete", function(event) {
		let route = $(this).attr('data-route');
		let entry = $(this).closest('tr');
		swal({
			title: 'Are you sure you want to delete this item?',
			icon: 'warning',
			buttons: {
				cancel: 'Cancel',
				confirm: 'Yes',
			},
		}).then((result) => {
			if (result) {
				$.ajax({
					url: route,
					type: "DELETE",
					success: function(response) {
						if (response) {
							swal({
								title: 'Your item has been deleted!',
								icon: 'success',
							});
							entry.remove();
						} else {
							swal({
								title: 'Something went wrong!',
								icon: 'error',
							});
						}
					},
				});
			}
		});
	});

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('deleteEntry');
</script>
@if (!request()->ajax()) @endpush @endif
