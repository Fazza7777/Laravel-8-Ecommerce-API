<button class="btn btn-sm btn-danger"
form='delete{{ $slug }}'><i class="fa fa-trash-alt"></i> Del</button>
<form action="{{ $action }}" id="delete{{ $slug }}"
method="POST" class="d-inline-block">
@csrf
@method('DELETE')
</form>
