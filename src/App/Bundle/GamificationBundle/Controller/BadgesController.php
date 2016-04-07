<?php
namespace App\Bundle\GamificationBundle\Controller;

use Domain\Entity\Image\Image;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class BadgesController extends FOSRestController
{
    public function getBadgesAction()
    {
        $repository = $this->container->get(
            'gamification.infrastructure.peristence.domain.entity.image.doctrine_image_repository'
        );

        $image = new Image(
            '12342',
            'testImage',
            3,
            4,
            'jpeg'
        );

        $repository->persist($image);

        return new Response("Badges is coming!");
    }
}
