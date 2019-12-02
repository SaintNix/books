<?php


class Auth
{
    protected $login;

    public function __construct()
    {
        $_SESSION['id'] = true;
        if ($_SESSION['id']) {
            $this->login = true;
        }
    }

    /**
     * @return bool
     */
    public function isLogin()
    {
        return $this->login;
    }
}