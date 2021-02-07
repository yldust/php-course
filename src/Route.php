<?php
namespace Base;

class Route
{
    private $controllerName;
    private $actionName;
    private $routes;
    private $processed = false;

    public function process()
    {
        if (!$this->processed) {
            $parts = parse_url($_SERVER['REQUEST_URI']);
            $path = $parts['path'];
            $route = $this->routes[$path] ?? null;

            if (!is_null($route)) {
                $this->controllerName = $route['controllerName'];
                $this->actionName = $route['actionName'];
            } else {
                $path = explode('/', $path);
                $this->controllerName = '\\App\\Controller\\' . ucfirst(strtolower($path[1]));
                $actionName = !empty($path[2]) ? $path[2] : 'index';
                $this->actionName = $actionName;
            }

            $this->processed = true;
        }
    }

    /**
     * @param string $path
     * @param string $controllerName
     * @param string $actionName
     */
    public function addRoute(string $path, string $controllerName, string $actionName): void
    {
        $this->routes[$path] = [
            'controllerName' => $controllerName,
            'actionName' => $actionName
        ];
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        if (!$this->processed) {
            $this->process();
        }

        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        if (!$this->processed) {
            $this->process();
        }

        return $this->actionName . 'Action';
    }
}
