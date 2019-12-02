<?php
ob_start();
?>
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>ID</th>
            <th>Изображение</th>
            <th>Название</th>
            <th>Авторы</th>
            <th>Дата</th>
            <th>Добавлена</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?
        foreach ($data['books_list'] as $book) {
            ?>
            <tr>
                <td id="<?= $book['book_id'] ?>" class="book_item"><?= $book['book_id'] ?></td>
                <td><img class="book_image" src="/img/<?= $book['pic_id'] ?>" alt="<?= $book['pic_id'] ?>"></td>
                <td><?= $book['title'] ?></td>
                <td><?php echo ucfirst(mb_substr($book['first_name'], 0, 1, 'UTF-8')) . "." . ucfirst(mb_substr($book['last_name'], 0, 1, 'UTF-8')) . ". " . $book['family_name']; ?></td>
                <td><?= $book['pub_date'] ?></td>
                <td><?= $book['add_date'] ?></td>
                <td>
                    <button class="change_book_get_modal_view button btn btn-primary" data-target="#exampleModalCenter"
                            data-toggle="modal" book_id="<?= $book['book_id'] ?>">Изменить
                    </button>
                    <button class="delete_book btn btn-secondary my-2 my-sm-0" book_id="<?= $book['book_id'] ?>">
                        Удалить
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

