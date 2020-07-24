<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Swagger\Annotations as SWG;

/**
 * @SWG\Tag(name="Test")
 */
class TestController extends AbstractFOSRestController
{
    /**
     * @return string
     * 
     * @SWG\Response(
     *     response=200,
     *     description="API is alive",
     *     @SWG\Schema(
     *         type="string",
     *         example={"Api works!"}
     *     )
     * )
     */
    public function apiWorks()
    {
        $view = $this->view('Api works!', 200);

        return $this->handleView($view);
    }

}