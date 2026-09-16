<!-- resources/views/components/message.blade.php -->
<div class="alert alert-{{ $type }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-info"></i> New Stock Added!</h5>
    {{ $message }}
    @if($stocksName)
        (Stock: {{ $stocksName }})
    @endif
</div>
