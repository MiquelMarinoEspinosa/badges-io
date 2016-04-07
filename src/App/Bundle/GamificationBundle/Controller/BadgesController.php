<?php
namespace App\Bundle\GamificationBundle\Controller;

use Domain\Entity\Image\Image;
use FOS\RestBundle\Controller\FOSRestController;
use Infrastructure\Persistence\Doctrine\Domain\Entity\Image\DoctrineImageRepository;
use Symfony\Component\HttpFoundation\Response;

class BadgesController extends FOSRestController
{
    public function getBadgesAction()
    {
        $repository = new DoctrineImageRepository(
            $this->container->get('doctrine.orm.entity_manager')
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
