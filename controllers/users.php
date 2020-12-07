<?php

class Users extends Controller
{
    protected function index(): void
    {
        $viewmodel = new UserModel();
        $this->renderView($viewmodel->index(), true);
    }

    protected function login(): void
    {
        $viewmodel = new UserModel();
        if (!(isset($_SESSION['is_logged_in']) && !$_SESSION['is_logged_in'])) {
            $this->renderView($viewmodel->login(), true);
        } else {
            $this->redirectRender('alreadyLogged', true);
        }
    }

    protected function register(): void
    {
        $viewmodel = new UserModel();
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) {
            $this->action = 'alreadyLogged';
            $this->renderView($viewmodel->register(), true);
        }else{
            $this->renderView($viewmodel->register(), true);
        }
    }

    protected function verify(): void
    {
        $viewmodel = new UserModel();
        $this->renderView($viewmodel->verify(), true);
    }

    protected function remindPassword(): void
    {
        $viewmodel = new UserModel();
        $this->renderView($viewmodel->remindPassword(), true);
    }

    protected function show(): void
    {
        $viewmodel = new UserModel();
        $this->renderView($viewmodel->show($this->request['id']), true);
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