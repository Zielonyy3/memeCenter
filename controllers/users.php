<?php 
class Users extends Controller{
    protected function index(){
        $viewmodel = new UserModel();
        $this->returnView($viewmodel->index(), true);
    }

    protected function login(){
        $viewmodel = new UserModel();
        if(!(isset($_SESSION['is_logged_in']) && !$_SESSION['is_logged_in'])){
            $this->returnView($viewmodel->login(), true);
        }else{
            $this->redirectView('alreadyLogged', true);
        }
    }

    protected function register(){
        $viewmodel = new UserModel();
        if(!(isset($_SESSION['is_logged_in']) && !$_SESSION['is_logged_in'])){
            $this->returnView($viewmodel->register(), true);
        }else{
            $this->redirectView('alreadyLogged', true);
        }
    }

    protected function verify(){
        $viewmodel = new UserModel();
        $this->returnView($viewmodel->verify(), true);
    }

    protected function remindPassword(){
        $viewmodel = new UserModel();
        $this->returnView($viewmodel->remindPassword(), true);
    }

    protected function show(){
        $viewmodel = new UserModel();
        $this->returnView($viewmodel->show($this->request['id']), true);
    }

    protected function logout(){
        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_data']);
        session_destroy();
        header('Location: '.ROOT_PATH);
    }
}
?>