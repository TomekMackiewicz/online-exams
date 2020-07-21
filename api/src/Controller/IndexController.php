<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;

class IndexController extends AbstractFOSRestController
{
    public function apiWorksAction()
    {
        $view = $this->view('Api works!', 200);

        return $this->handleView($view);
    }

}