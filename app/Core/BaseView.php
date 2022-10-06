<?php


namespace App\Core;

class BaseView
{

    protected string $templatesPath;

    public function __construct()
    {
        $this->templatesPath = Config::getEnvValue('TEMPLATES');
    }

}