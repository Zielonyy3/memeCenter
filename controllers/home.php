<?php

class Home extends Controller
{
    protected function Index()
    {
        $viewmodel = new HomeModel();
        $this->renderView($viewmodel->Index(), true);
    }
}

?>