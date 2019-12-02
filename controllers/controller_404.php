<?php


class controller_404 extends Controller
{
    public function __construct()
    {
        $this->view = new View();
    }

    function start()
    {
        $this->view->generate('404_view.php','template_view.php', '');
    }
}