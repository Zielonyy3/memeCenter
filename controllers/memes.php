<?php

class Memes extends Controller
{
    protected function index()
    {
        $viewmodel = new MemeModel();
        $this->renderView($viewmodel->index(), true);
    }

    protected function add()
    {
        $viewmodel = new MemeModel();
        $this->renderView($viewmodel->add(), true);
    }

    protected function show()
    {
        $viewmodel = new MemeModel();
        $this->renderView($viewmodel->show($this->request['id']), true);
    }
}

?>