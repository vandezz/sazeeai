<?php

namespace App\Controllers;

/**
 * Home Controller — Landing Page
 */
class Home extends BaseController
{
    public function index(): string
    {
        return $this->render('home/landing');
    }
}
