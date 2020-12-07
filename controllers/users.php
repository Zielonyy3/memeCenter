<?php

class Users extends Controller
{
    protected function index(): void
    {
        $viewmodel = new UserModel();
        $this->viewdata = $viewmodel->index();
    }

    protected function login(): void
    {
        $viewmodel = new UserModel();
        $viewmodel->login();
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
            $this->action = 'alreadyLogged';
        }
    }

    protected function register(): void
    {
        $viewmodel = new UserModel();
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
            $this->action = 'alreadyLogged';
        }else{
            $viewmodel->register();
        }
    }

    protected function verify(): void
    {
        $viewmodel = new UserModel();
        $this->viewdata = $viewmodel->verify();
    }

    protected function remindPassword():void
    {
        $viewmodel = new UserModel();
        $this->viewdata =  $viewmodel->remindPassword();
    }

    protected function show(): void
    {
        $viewmodel = new UserModel();
        $this->viewdata = $viewmodel->show($this->request['id']);
    }

    protected function logout(): void
    {
        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_data']);
        session_destroy();
        header('Location: ' . ROOT_PATH);
    }
}

?>