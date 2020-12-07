<?php

class Home extends Controller
{
    protected function Index(): void
    {
        $viewmodel = new HomeModel();
        $this->viewdata = $viewmodel->Index();
    }
}

?>