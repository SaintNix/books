<?php
//$html_data = "<tbody>";
ob_start();
?>
    <form id="book-add" action="/" method="post">
        <input name="boook_id" type="text" hidden="hidden" hidden value="0">
        <select id="select-state" name="author_ids[]" multiple class="demo-default" style="width:250px"
                placeholder="Выбор...">
            <option value="">Выбор...</option>
            <? foreach ($data['authors_list'] as $author) {
                echo "<option value='" . $author['author_id'] . "'>" . $author['family_name'] . "</option>";
            } ?>
        </select>
        <label>
            <input name="book_name" class="form-control" type="text" placeholder="Назавание" value=""/>
        </label>
        <label>
            <input name="book_public_date" class="form-control" type="number" min="0" max="2019" step="1" value="2019"
            />
        </label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Выберите файл</label>
        </div>
    </form>
<?php
$html_data = ob_get_clean();