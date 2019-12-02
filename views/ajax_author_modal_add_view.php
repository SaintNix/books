<?php
ob_start();
?>
    <form id="author-add" action="/" method="post">
        <input name="author_id" class="form-control" type="text" hidden="hidden" hidden value="0">
        <input name="family_name" class="form-control" type="text" placeholder="Фамилия" value="">
        <input name="first_name" class="form-control" type="text"placeholder="Имя" value="">
        <input name="last_name" class="form-control" type="text" placeholder="Отчество"value="">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="validatedCustomFile" lang="ru">
            <label class="custom-file-label" for="validatedCustomFile">Выберите файл</label>
        </div>
    </form>
<?php
$html_data = ob_get_clean();