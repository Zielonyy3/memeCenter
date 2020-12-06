<?php 
class Memes extends Controller{
    protected function index(){
        $viewmodel = new MemeModel();
        $this->returnView($viewmodel->index(), true);
    }

    protected function add(){
        $viewmodel = new MemeModel();
        $this->returnView($viewmodel->add(), true);
    }

    protected function show(){
        $viewmodel = new MemeModel();
        $this->returnView($viewmodel->show($this->request['id']), true);
    }
}
 ?>