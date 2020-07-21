<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Swagger\Annotations as SWG;

class TestController extends AbstractFOSRestController
{
    /**
     * @SWG\Response(
     *     response=200,
     *     description="Returns info if api works",
     *     @SWG\Schema(
     *         type="string",
     *         example={"Api works!"}
     *     )
     * )
     * @return string
     */
    public function apiWorks()
    {
        $view = $this->view('Api works!', 200);

        return $this->handleView($view);
    }

}