<?php

abstract class Controller
{
    protected $request;
    protected $action;

    public function __construct(array $request, string $action)
    {
        $this->action = $action;
        $this->request = $request;
    }

    public function executeAction()
    {
        return $this->{$this->action}();
    }

    protected function renderView($viewmodel, bool $fullview): void
    {
        $className = get_class($this);
        $view = "views/$className/$this->action.php";
        if ($fullview) {
            require('views/main.php');
        } else {
            require($view);
        }
    }
}

?>