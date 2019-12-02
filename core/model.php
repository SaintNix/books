<?php

class Model
{
    protected $PDO;

    public function __construct()
    {
        $dbCred = Config::dbCred();

        $host = $dbCred['dbHost'];
        $db = $dbCred['dbName'];
        $user = $dbCred['dbUser'];
        $pass = $dbCred['dbPass'];
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->PDO = new PDO($dsn, $user, $pass, $opt);
        $this->PDO->exec("set names utf8");
    }

    public function getPost() {
        return $_POST;
    }

    function getBooksList()
    {
        try {
            $stmt = $this->PDO->prepare("
SELECT books.*, authors.first_name, authors.last_name, authors.family_name 		
 FROM books 
JOIN links 
 ON books.book_id = links.book_id 
JOIN authors 
 ON authors.author_id = links.author_id GROUP BY books.book_id ORDER BY books.book_id ASC LIMIT 0,20");
            $stmt->execute();
        } catch (PDOException $Exception) {
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllAuthors()
    {
        try {
            $stmt = $this->PDO->prepare("
SELECT authors.author_id, authors.first_name, authors.last_name, authors.family_name, authors.author_pic 
FROM authors ORDER BY authors.family_name ASC LIMIT 0,10");
            $stmt->execute();
        } catch (PDOException $Exception) {
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllAuthorsOrderById()
    {
        try {
            $stmt = $this->PDO->prepare("
SELECT authors.author_id, authors.first_name, authors.last_name, authors.family_name, authors.author_pic 
FROM authors ORDER BY authors.author_id ASC LIMIT 0,10");
            $stmt->execute();
        } catch (PDOException $Exception) {
            return false;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getOneAuthorById ($author_id) {
        $stmt = $this->PDO->prepare("SELECT * FROM authors WHERE author_id = :author_id");
        try {
            $stmt->execute(array($author_id));
        } catch (PDOException $Exception) {
            return false;
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}