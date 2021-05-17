<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    public function test()
    {
        return new Response(
            '<html><body>Test page</body></html>'
        );
    }
}