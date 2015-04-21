<?php


namespace Core\Controllers;


class Errors extends Controller
{
    public $layout = 'errors';

    public function controllerNotFound($controllerName)
    {
        $this->view = 'controllerNotFound';
        $this->set('controllerName',$controllerName);
    }

    public function methodeNotFound($controllerName,$methodeName)
    {
        $this->view = 'methodeNotFound';
        $d['controllerName'] = $controllerName;
        $d['methodeName'] = $methodeName;
        $this->set($d);
    }

    public function layoutNotFound($layout)
    {
        $this->view = 'layoutNotFound';
        $this->set('layout', $layout);
    }

    public function viewNotFound($controllerName, $view)
    {
        $this->view = 'viewNotFound';
        $d['controllerName'] = $controllerName;
        $d['viewName'] = $view;
        $this->set($d);
    }
}