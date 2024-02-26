<script type="text/javascript">

    $(document).ready(function () {
        
        $.ajax({
            type: "POST",
            url: "/items",
            data: "data",
            dataType: "JSON",
            success: function (response) {
                console.log()
            }
        });
    });

</script>