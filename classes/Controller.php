<?php 
abstract class Controller{
    protected $request;
    protected $action;

    public function __construct($request, $action){
        $this->action = $action;
        $this->request= $request;
    }

    public function executeAction(){
        return $this->{$this->action}();
    }

    protected function returnView($viewmodel, $fullview){
        $view = 'views/'.get_class($this).'/'.$this->action.'.php';
        if($fullview){
            require('views/main.php');
        }else{
            require($view);
        }
    }
    protected function redirectView($redirectedAction, $fullview){
        $view = 'views/'.get_class($this).'/'.$redirectedAction.'.php';
        if($fullview){
            require('views/main.php');
        }else{
            require($view);
        }
    }
}
?>