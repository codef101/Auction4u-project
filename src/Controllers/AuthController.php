<?php

namespace App\Controllers;

use PDO;
use Slim\Views\Twig;

class AuthController {
    protected $view;
    protected $db;
    protected $app;
    protected $flash;

    public function __construct(Twig $view, PDO $db)
    {
       $this->view = $view;
       $this->db = $db;
    }

    public function login($request, $response, $args)
    {
        return $this->view->render($response, 'login.twig', [
            'title' =>'Login'
        ]);
    }

}
