<!-- resources/views/components/notification.blade.php -->
<div class="alert alert-{{ $type }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-info"></i> Order Status Updated!</h5>
    {{ $message }}
    @if($orderId)
        (Order ID: {{ $orderId }})
    @endif
</div>
