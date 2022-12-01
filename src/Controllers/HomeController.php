<?php

namespace App\Controllers;

use PDO;
use Slim\Views\Twig;

class HomeController {
    protected $view;
    protected $db;
    protected $app;
    protected $flash;

    public function __construct(Twig $view, PDO $db)
    {
       $this->view = $view;
       $this->db = $db;
    }

    public function index($request, $response, $args)
    {
        return $this->view->render($response, 'homepage.twig', [
            'page' =>'homepage.php'
        ]);
    }

}
