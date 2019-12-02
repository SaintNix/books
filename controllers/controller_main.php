<?php


class Controller_Main extends Controller
{
    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function start()
    {
        $data['book_list'] = $this->model->getBooksListMultiAuthors();
        $data['author_list'] = $this->model->getAllAuthors();
        $this->view->generate('main_view.php','template_view.php', $data);
    }

}