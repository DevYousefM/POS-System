@if (session('message'))
    <div id="result" class="alert alert-danger alert-dismissible" role="alert">
        {{ session('message') }}
    </div>
@endif
<script>
    let result = document.getElementById("result");
    if (result) {
        setTimeout(() => {
            result.remove();
        }, 5000);
    }
</script>
