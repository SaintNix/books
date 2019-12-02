<?php
ob_start();
?>
    <form id="author-add" action="/" method="post">
        <input name="author_id" class="form-control" type="text" hidden="hidden" hidden value="<?=$data['author_id']?>">
        <input name="family_name" class="form-control" type="text" placeholder="Фамилия" value="<?=$data['family_name']?>">
        <input name="first_name" class="form-control" type="text"placeholder="Имя" value="<?=$data['first_name']?>">
        <input name="last_name" class="form-control" type="text" placeholder="Отчество" value="<?=$data['last_name']?>">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </form>
<?php
$html_data = ob_get_clean();