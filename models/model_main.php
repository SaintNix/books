<?php

class Model_Main extends Model
{
    function getBooksListMultiAuthors()
    {
        try {
        $stmt = $this->PDO->prepare("SELECT books.*, group_concat(CONCAT(authors.first_name,',',authors.last_name,',',authors.family_name) SEPARATOR '::') AS full_name 											
 FROM books 											
JOIN links 											
 ON books.book_id = links.book_id 											
JOIN authors 											
 ON authors.author_id = links.author_id GROUP BY books.book_id ORDER BY books.book_id ASC LIMIT 0,10;											
");
            $stmt->execute();
        } catch (PDOException $Exception) {
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
