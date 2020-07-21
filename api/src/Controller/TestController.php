<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;

class TestController extends AbstractFOSRestController
{
    public function apiWorks()
    {
        $view = $this->view('Api works!', 200);

        return $this->handleView($view);
    }

}