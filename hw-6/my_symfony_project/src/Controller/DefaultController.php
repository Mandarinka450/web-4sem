<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    public function index()
    {
        return new Response(
            '<html><body>Hello from Symfony</body></html>'
        );
    }
}