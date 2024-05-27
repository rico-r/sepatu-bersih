
<div class="container position-fixed start-0 end-0 top-0 col-8 mt-5 z-2" id="alert-container">
    <div class="alert alert-dismissible" id="alert">
        <span id="message"></span>
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
@if(session()->has('message'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    showMessage('{{ session('message') }}');
})
</script>
@endif
