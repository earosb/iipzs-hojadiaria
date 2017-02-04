@foreach ($messages as $msg)
    <div class="alert alert-dismissible alert-{{ $msg['type'] }} fade in">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <p><strong>{{ $msg['message'] }}</strong></p>
    </div>
@endforeach