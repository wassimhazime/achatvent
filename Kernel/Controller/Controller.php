<?php

namespace Kernel\Controller;

use core\html\TAG;
use core\MVC\MODEL\Model;
use core\INTENT\Intent;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller
{

    protected $model;
    protected $Request;
    protected $Response;
    protected $name;
    protected $action;
    protected $param;

    function __construct(ServerRequestInterface $Request, ResponseInterface $Response)
    {
        $this->Request = $Request;
        $this->Response = $Response;

        $this->name = $Request->getAttribute('MVC')["controller"];
        $this->action = $Request->getAttribute('MVC')["action"];
        $this->param = $Request->getAttribute('MVC')["param"];
    }

    protected function setModel(Model $model)
    {
        $this->model = $model;
    }

    protected function show(array $mode = Intent::MODE_SELECT_MASTER_MASTER, $condition = 1)
    {
       

        $intent = $this->model->show($mode, $condition);

        return (new TAG())->tableHTML($intent);
    }

    protected function getFormHTML(array $mode = Intent::MODE_FORM)
    {
       
        $intent = $this->model->form($mode);

        return (new TAG())->FormHTML($intent);
    }

    protected function setData($data, $mode = Intent::MODE_INSERT)
    {
        

        $intent = $this->model->setData($data, $mode);
    }

    public function run(Model $model)
    {
        

        $this->setModel($model);

        if (is_callable(array($this, $this->action), $this->param)) {
            return call_user_func(array($this, $this->action), $this->param);
        } else {
            return $this->NotFound();
        }
    }

    protected function NotFound()
    {
        return [];
    }
}
