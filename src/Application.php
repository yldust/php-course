<?php

namespace Base;

use App\Controller\Blog;
use App\Controller\Login;

class Application
{
    private $route;
    private $controller;
    private $actionName;

    public function __construct()
    {
        $this->route = new Route();
    }

    public function run()
    {
        try {
            $this->addRoutes();
            $this->initController();
            $this->initAction();
            $view = new View();
            $this->controller->setView($view);

            $session = new Session();
            $session->init();
            $this->controller->setSession($session);

            $content = $this->controller->{$this->actionName}();
            echo $content;
        } catch (RouteException $e) {
            header("HTTP/1.0 404 Not Found");
            echo $e->getMessage();
        } catch (RedirectException $e) {
            header('Location: ' . $e->getUrl());
            die;
        }
    }

    private function addRoutes()
    {
        $this->route->addRoute('/', Blog::class, 'index');
    }

    private function initController()
    {
        $controllerName = $this->route->getControllerName();

        if (!class_exists($controllerName)) {
            $errorMessage = "Can' find controller " . $controllerName;
            throw new RouteException($errorMessage);
        }

        $this->controller = new $controllerName;
    }

    private function initAction()
    {
        $actionName = $this->route->getActionName();

        if (!method_exists($this->controller, $actionName)) {
            $errorMessage = "Action " . $actionName . " not found in " . get_class($this->controller);
            throw new RouteException($errorMessage);
        }

        $this->actionName = $actionName;
    }
}
