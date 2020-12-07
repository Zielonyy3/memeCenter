<?php

class Root
{
    private $controller;
    private $action;
    private $request;

    public function __construct(array $request)
    {
        $this->request = $request;
        if ($this->request['controller'] == "") {
            $this->controller = 'home';
        } else {
            $this->controller = $this->request['controller'];
        }
        if ($this->request['action'] == "") {
            $this->action = 'index';
        } else {
            $this->action = $this->request['action'];
        }
    }

    public function createController(): ?Controller
    {
        if (class_exists($this->controller)) {
            $parents = class_parents($this->controller);
            if (in_array("Controller", $parents)) {
                if (method_exists($this->controller, $this->action)) {
                    return new $this->controller($this->request, $this->action);
                } else {
                    echo '<h1>Method does not exist</h1>';
                    return null;
                }
            } else {
                echo '<h1>Base controller is not found';
                return null;
            }
        } else {
            echo '<h1>Controller class does not exist</h1>';
            return null;
        }
    }
}

?>