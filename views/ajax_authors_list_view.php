<?php
ob_start();
?>
    <table class="table table-striped table-sm">
    <thead>
    <tr>
        <th>ID</th>
        <th>Изображение</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Фамилия</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
<?
foreach ($data['authors_list'] as $author) {
    ?>
    <tr>
        <td><?= $author['author_id'] ?></td>
        <td><img src="/img/<?= $author['author_pic'] ?>" height="20px"></td>
        <td><?= $author['first_name'] ?></td>
        <td><?= $author['last_name'] ?></td>
        <td><?= $author['family_name'] ?></td>
        <td>
            <button class="change_author_get_modal_view button btn btn-primary" data-target="#exampleModalCenter"
                    data-toggle="modal" author_id="<?= $author['author_id'] ?>">Изменить
            </button>
            <button class="delete_author btn btn-secondary my-2 my-sm-0" author_id="<?= $author['author_id'] ?>">Удалить
            </button>
        </td>
    </tr>
    <?
}
?>
    </tbody>
    </table>
<?
$html_data = ob_get_clean();
