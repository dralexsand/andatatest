<?php


namespace App\Controllers;

use App\Core\Config;
use App\Core\View;

class BaseController
{
    protected View $viewInstance;

    public function __construct()
    {
        $this->viewInstance = new View();
    }

    /**
     * @param string $templateName
     * @param array $params
     * @return void
     */
    public function view(string $templateName, array $params = []): void
    {
        $this->viewInstance->render($templateName, $params);
    }
}