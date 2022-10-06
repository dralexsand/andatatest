<?php


namespace App\Controllers;

class NotFoundController extends BaseController
{
    /**
     * @return null
     */
    public function index()
    {
        return $this->view('404.template');
    }
}