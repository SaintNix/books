<?php


class Controller_Admin extends Controller
{
    function __construct()
    {
        $this->model = new Model_Admin();
        $this->view = new View();
    }

    function start()
    {
        $this->view->generate('admin_view.php','template_view.php', '');
    }
}