
@if(session()->has('message'))
<div class="container position-fixed start-0 end-0 top-0 col-5 mt-5 z-2" id="alert-container">
    <div class="alert alert-success alert-dismissible" id="alert">
        <span id="message">{{ session('message') }}</span>
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    </div>
</div>

<script>
    setTimeout(function() {
        document.getElementById('alert-container').style.display = 'none';
    }, 5000)
</script>
@endif