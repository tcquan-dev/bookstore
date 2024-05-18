@if ($crud->hasAccess('delete', $entry))
<button data-route="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-sm btn-delete btn-link" data-button-type="delete">
	<span><i class="la la-trash"></i> {{ trans('backpack::crud.delete') }}</span>
</button>
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script type="text/javascript" src="{{ asset('js/alert.js') }}"></script>
@if (!request()->ajax()) @endpush @endif
