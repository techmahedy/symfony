<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/test/{name?}", name="about")
     */
    public function main(Request $request)
    {   
        $name = $request->get('name');
        return $this->render('home/about.html.twig',[
            'name' => $name
        ]);
    }
}
