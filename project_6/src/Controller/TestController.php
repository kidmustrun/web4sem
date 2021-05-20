<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController
{
    /**
     * Load the site definition and redirect to the default page.
     *
     * @Route("/users")
     */
    public function users()
    {
        return new Response(
            json_encode([
                new class('irina', 19){
                    public $name;
                    public $age;
                    public function __construct($name, $age)
                    {
                        $this->name = $name;
                        $this->age = $age;
                    }
                },
                new class('sasha', 24){
                    public $name;
                    public $age;
                    public function __construct($name, $age)
                    {
                        $this->name = $name;
                        $this->age = $age;
                    }
                }
            ]),
            Response::HTTP_OK,
            [
                'Content-type' => 'application/json'
            ]
        );
    }
}