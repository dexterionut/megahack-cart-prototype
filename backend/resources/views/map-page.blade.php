<script src="./js/test.js"></script>

<script>
    var shops = {!! isset($shops['data']) ? json_encode($shops['data']) : json_encode([]) !!};
    console.log(shops);
</script>
