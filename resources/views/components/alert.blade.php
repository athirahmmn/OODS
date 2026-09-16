<!-- resources/views/components/alert.blade.php -->
<div class="alert alert-{{ $type }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-{{ $icon }}"></i> {{ $title }}</h5>
    {{ $message }}
</div>
