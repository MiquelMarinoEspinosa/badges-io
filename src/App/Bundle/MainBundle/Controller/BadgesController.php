<?php
namespace App\Bundle\MainBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class BadgesController extends FOSRestController
{
    public function getBadgesAction()
    {
        return new Response("Badges is coming!");
    }
}
