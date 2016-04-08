<?php
namespace App\Bundle\GamificationBundle\Controller;

use Domain\Entity\Image\Image;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Response;

class BadgesController extends FOSRestController
{
    /**
     * @ApiDoc(
     *  description = "The artist resource by artist id",
     *  requirements={
     *    {"name"="id", "dataType"="integer", "requirement"="\d+", "description"="The artist id"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      404="Returned when no artist is found",
     *  }
     * )
     */
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
