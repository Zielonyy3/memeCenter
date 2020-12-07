<?php

abstract class Controller
{
    protected $request;
    protected $action;
    protected $viewdata;

    public function __construct(array $request, string $action)
    {
        $this->action = $action;
        $this->request = $request;
    }

    public function executeAction()
    {
        return $this->{$this->action}();
    }

    public function render(bool $fullview): string
    {
        $className = get_class($this);
        $view = "views/$className/$this->action.php";
        $viewdata = $this->viewdata;
        ob_start();
        extract($viewdata); #wydaje mi się, że to nawet nie jest potrzebne
        if ($fullview) {
            require('views/main.php');
        } else {
            require($view);
        }
        $result = ob_get_clean();
        return $result;
    }
}

?>