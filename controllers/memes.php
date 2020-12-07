<?php

class Memes extends Controller
{
    protected function index(): void
    {
        $viewmodel = new MemeModel();
        $this->viewdata = $viewmodel->index();
    }

    protected function add()
    {
        $viewmodel = new MemeModel();
        $this->viewdata = $viewmodel->add();
    }

    protected function show()
    {
        $viewmodel = new MemeModel();
        $this->viewdata =  $viewmodel->show($this->request['id']);
    }
}

?>