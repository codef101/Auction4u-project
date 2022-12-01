<?php

namespace App\Controllers;

use PDO;
use Slim\Views\Twig;

class HomeController {
    protected $view;
    protected $db;
    protected $app;
    protected $flash;

    public function __construct(PDO $db)
    {
       $this->db = $db;
    }

    public function index($request, $response, $args)
    {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'profile.html');
    }

}
