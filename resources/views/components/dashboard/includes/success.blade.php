@if (session('success'))
    <div class="alert alert-success" id="success">{{ session('success') }}</div>
@endif
<script>
    let alert = document.getElementById("success");
    if (alert) {
        setTimeout(() => {
            alert.remove();
        }, 2000);
    }
</script>

