<?php
ob_start();
//pretty_print($data, 0);
foreach ($data as $book) {
    $name = [];
    foreach (explode("::", $book['full_name']) as $item) {
        $temp = explode(",", $item);
        $name[] = ucfirst(mb_substr($temp[0], 0, 1, 'UTF-8')) . "." . ucfirst(mb_substr($temp[1], 0, 1, 'UTF-8')) . ". " . $temp[2];
    }
    $print_name = implode(", ", $name);
    ?>
    <div class="book_item" id="<?= $book['book_id'] ?>">
        <img class="book_image" src="img/<?= $book['pic_id'] ?>" alt="<?= $book['pic_id'] ?>">
        <div><?= $book['title'] ?></div>
        <div><?= $print_name ?></div>
        <div><?= $book['pub_date'] ?></div>
    </div>
    <?php
}
$html_data = ob_get_clean();

