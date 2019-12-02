<?php


class Controller_admin_authors extends Controller
{
    function __construct()
    {
        $this->model = new Model_admin_authors();
        $this->view = new View();
    }

    function start()
    {
        $data['authors_list'] = $this->model->getAllAuthors();
        $this->view->generate('admin_authors_view.php','template_view.php', $data);
    }
}