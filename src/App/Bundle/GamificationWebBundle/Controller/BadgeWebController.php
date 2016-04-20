<?php

namespace App\Bundle\GamificationWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BadgeWebController extends Controller
{
    public function indexAction($userId)
    {
        return $this->render('GamificationWebBundle::index.html.twig', ['userId' => $userId]);
    }
}
