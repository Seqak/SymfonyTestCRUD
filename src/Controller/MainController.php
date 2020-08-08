<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\DateNow;

/**
 * Class MainController
 * @Route("/", name="main.")
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(DateNow $dateNow)
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'date' => $dateNow->getDate()
        ]);
    }
}
