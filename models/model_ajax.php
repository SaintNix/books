<?php

class Model_Ajax extends Model
{
    public function add_book($title, $author_ids, $pub_date, $pic_id)
    {
        $data = [
            'title' => $title,
            'pub_date' => $pub_date,
            'pic_id' => $pic_id,
        ];
        try {
            $stmt = $this->PDO->prepare("INSERT INTO books (title, add_date, pub_date, pic_id) VALUES (:title, CURRENT_TIMESTAMP, :pub_date, :pic_id)");
            $stmt->execute($data);
        } catch (PDOException $Exception) {
            return false;
        }
        $this->add_authors($this->PDO->lastInsertId(), $author_ids);
        return $this->PDO->lastInsertId();
    }

    public function add_author($first_name, $last_name, $family_name, $pic_id)
    {
        $data = [
            'first_name' => $first_name,
            'family_name' => $family_name,
            'last_name' => $last_name,
            'author_pic' => $pic_id,
        ];
        try {
            $stmt = $this->PDO->prepare("INSERT INTO authors (first_name, family_name, last_name, author_pic) VALUES (:first_name, :family_name, :last_name, :author_pic)");
            $stmt->execute($data);
        } catch (PDOException $Exception) {
            return false;
        }
    }

    public function file_upload($files)
    {
        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/img/';
        $file_name = 'no_pic.jpg';

        // cоздадим папку если её нет
        if (!is_dir($uploaddir)) mkdir($uploaddir, 0777);

        $done_files = array();

        foreach ($files as $file) {
            if ($file["type"] == 'image/gif') {
                $end = ".gif";
            } elseif ($file["type"] == 'image/png') {
                $end = ".png";
            } elseif ($file["type"] == 'image/jpeg') {
                $end = ".jpeg";
            } else {
                return false;
            }

            $file_name = md5($file['name']) . $end;

            if (move_uploaded_file($file['tmp_name'], "$uploaddir/$file_name")) {
                $done_files[] = realpath("$uploaddir/$file_name");
            }
        }
        return $done_files ? $file_name : false;
    }

    public function add_authors($book_id, $author_ids)
    {
        $stmt = $this->PDO->prepare("INSERT INTO links (book_id, author_id) VALUES (:book_id, :author_id)");
        foreach ($author_ids as $author_id) {
            try {
                $stmt->execute(['book_id' => $book_id, 'author_id' => $author_id]);
            } catch (PDOException $Exception) {
                return false;
            }
        }
    }

    public function delete_book($book_id)
    {
        $stmt = $this->PDO->prepare("DELETE books,links FROM books
INNER JOIN links 
ON 
links.book_id = books.book_id 
WHERE
books.book_id = :book_id");
        try {
            $stmt->execute(array($book_id));
        } catch (PDOException $Exception) {
            return false;
        }
    }

    public function delete_author($author_id)
    {
        $stmt = $this->PDO->prepare("DELETE FROM authors WHERE author_id = :author_id");
        try {
            $stmt->execute(array($author_id));
        } catch (PDOException $Exception) {
            return false;
        }
        $stmt = $this->PDO->prepare("DELETE FROM links WHERE author_id = :author_id");
        try {
            $stmt->execute(array($author_id));
        } catch (PDOException $Exception) {
            return false;
        }
        $stmt = $this->PDO->prepare("DELETE books 
  FROM books
  LEFT JOIN links ON books.book_id=links.book_id
WHERE links.book_id is null");
        try {
            $stmt->execute();
        } catch (PDOException $Exception) {
            return false;
        }
    }

    public function get_one_book($book_id)
    {
        $stmt = $this->PDO->prepare("SELECT books.*					
 FROM books 
WHERE books.book_id = :book_id");
        try {
            $stmt->execute(array($book_id));
        } catch (PDOException $Exception) {
            return false;
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function get_books_authors($book_id)
    {
        $stmt = $this->PDO->prepare("SELECT authors.* FROM					
authors JOIN links 					
ON links.author_id = authors.author_id 					
JOIN books 					
ON links.book_id = books.book_id WHERE books.book_id = :book_id");
        try {
            $stmt->execute(array($book_id));
        } catch (PDOException $Exception) {
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function change_book_data($title, $pub_date, $pic_id, $book_id)
    {
        $data = [
            'title' => $title,
            'pub_date' => $pub_date,
            'pic_id' => $pic_id,
            'book_id' => $book_id,
        ];
        try {
            $stmt = $this->PDO->prepare("UPDATE books SET title = :title, add_date = CURRENT_TIMESTAMP, pub_date = :pub_date, pic_id = :pic_id WHERE book_id = :book_id");
            $stmt->execute($data);
        } catch (PDOException $Exception) {
            return false;
        }
        return true;
    }

    public function change_author_data($first_name, $family_name, $last_name, $author_pic, $author_id)
    {
        $data = [
            'first_name' => $first_name,
            'family_name' => $family_name,
            'last_name' => $last_name,
            'author_pic' => $author_pic,
            'author_id' => $author_id,
        ];
        try {
            $stmt = $this->PDO->prepare("UPDATE authors SET first_name = :first_name, family_name = :family_name, last_name = :last_name, author_pic = :author_pic WHERE author_id = :author_id");
            $stmt->execute($data);
        } catch (PDOException $Exception) {
            return false;
        }
        return true;
    }

    public function change_book_authors($book_id, $author_ids)
    {
        $stmt = $this->PDO->prepare("DELETE FROM links WHERE book_id = :book_id");
        try {
            $stmt->execute(array($book_id));
        } catch (PDOException $Exception) {
            return false;
        }
        $this->add_authors($book_id, $author_ids);
        return true;
    }

    public function getFilteredFrontData($sort, $authors_ids)
    {
        $filter_SQL = '';
        if ($sort == 1) {
            $sort_data = 'DESC';
        } else {
            $sort_data = 'ASC';
        }
        $data = [];
        if (!empty($authors_ids)) {
            $filter_SQL = " WHERE ";
            $filter_SQL_temp = [];
            foreach ($authors_ids as $key => $author_id) {
                $filter_SQL_temp [] = "authors.author_id = :author_id$key";
                $data["author_id$key"] = $author_id;
            }
            $filter_SQL_temp = implode(" OR ", $filter_SQL_temp);
            $filter_SQL .= $filter_SQL_temp;
        }

        try {
            $stmt = $this->PDO->prepare("
SELECT books.*, group_concat(CONCAT(authors.first_name,',',authors.last_name,',',authors.family_name) SEPARATOR '::') AS full_name		
 FROM books 
JOIN links 
 ON books.book_id = links.book_id 
JOIN authors 
 ON authors.author_id = links.author_id " . $filter_SQL . " GROUP BY books.book_id ORDER BY books.add_date " . $sort_data . " LIMIT 0,20");
            $stmt->execute($data);
        } catch (PDOException $Exception) {
            return $data;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
