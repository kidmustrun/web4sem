<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\HeaderUtils;

class TestController
{
    /**
     * Load the site definition and redirect to the default page.
     *
     * @Route("/users")
     */
    public function users(Request $request, HeaderUtils $headerUtils)
    {
        $authMetaData = $request -> headers ->get('Authorization');
        if($authMetaData != ''){
            [$type, $credentials] = explode(' ', $authMetaData);
            [$login, $pw] = explode(':', base64_decode($credentials));
            if($headerUtils -> checkLogin($login, $pw)){
                return new Response(
                    json_encode(
                       [
                           'message' => 'Ok, all right',
                           'type' => $type
                       ],
                       JSON_THROW_ON_ERROR
                ),
                    
                    Response::HTTP_OK,
                    [
                        'Content-type' => 'application/json'
                    ]
                );
            }
        else 
        return new Response(
        'Not authorized',
        Response::HTTP_UNAUTHORIZED,
        ['WWW-Authenticate' => 'Basic realm="Access to the staging site", charset="UTF-8"']
    );
    
} else  return new Response(
    'Not authorized',
    Response::HTTP_UNAUTHORIZED,
    ['WWW-Authenticate' => 'Basic realm="Access to the staging site", charset="UTF-8"']
);
    }
}