<script src="/js/jquery.min.js"></script>
<script src="/js/selectize.js"></script>
<link rel="stylesheet" href="/css/selectize.bootstrap3.css">

<select id="select-state" name="state[]" multiple class="demo-default" style="width:50%"
        placeholder="Выбор...">
    <option value="">Select a state...</option>
    <option value="AL">Alabama</option>
    <option value="AZ">Arizona</option>
    <option value="AR">Arkansas</option>
    <option value="CA">California</option>
    <option value="CO">Colorado</option>
</select>
<script>
    $('#select-state').selectize({
        maxItems: 3
    });
</script>
<?php
