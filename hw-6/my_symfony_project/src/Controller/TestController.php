<?php

# src/Controller/testController.php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController
{
    /**
     * @Route("/", methods = {"GET"})
     */
    public function list()
    {
        return new Response(
           json_encode(
             [
               'some-value'=> 123,
               'string' => 'striiiing',
             ]
           ),
            Response::HTTP_OK,
            [
              'Content-type' => 'application/json'
            ]
        );
    }
}