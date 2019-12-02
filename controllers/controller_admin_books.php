<?php


class Controller_admin_books extends Controller
{
    function __construct()
    {
        $this->model = new Model_admin_books();
        $this->view = new View();
    }

    function start()
    {
        $data['books_list'] = $this->model->getBooksList();
        $data['authors_list'] = $this->model->getAllAuthors();
        $this->view->generate('admin_books_view.php','template_view.php', $data);
    }
}