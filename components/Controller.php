<?php

namespace components;

abstract class Controller
{
    /**
     * @param $viewPath
     */
    public function loadView(string $viewName, ?array $vars = []): void
    {
        extract($vars);
        require ROOT . '/app/views/' . trim($viewName, '/ ') . '.php';
    }
}
