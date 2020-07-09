<?php

namespace components;

class Router
{
	private $routes;

    /**
     * Router constructor.
     */
	public function __construct()
	{
		$routesPath = ROOT . '/config/routes.php';
		$this->routes = include($routesPath);
	}

    /**
     * @return string
     */
	private function getURI(): string
	{
		if (!empty($_SERVER['REQUEST_URI'])) {
			return $uri = trim($_SERVER['REQUEST_URI'], '/');
		}
	}

    /**
     * @return bool
     */
	public function run(): bool
	{
		$uri = $this->getURI();

		foreach ($this->routes as $uriPattern => $path) {

			if (preg_match("~$uriPattern~", $uri)){
			    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

				$segments = explode('/', $internalRoute);

				$controllerName = ucfirst(array_shift($segments)) . 'Controller';

				$actionName = 'action' . ucfirst(array_shift($segments));

                if (strpos($actionName, '?')) {
                    $actionName = strstr($actionName, '?', true);
                }

				$parameters = $segments;

                $controllerClass = "\\app\\controllers\\{$controllerName}";

				$controllerObject = new $controllerClass();

				$result = call_user_func_array(array($controllerObject, $actionName), $parameters);

				if ($result != null) {
					break;
				}
			}
		}

        return true;
	}
}