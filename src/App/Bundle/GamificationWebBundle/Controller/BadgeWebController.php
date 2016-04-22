<?php

namespace App\Bundle\GamificationWebBundle\Controller;

use Infrastructure\Resource\Domain\Entity\Badge\BadgeResource;
use Interactor\CommandHandler\ListBadges\ListBadgesCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BadgeWebController extends Controller
{
    const IS_MULTI_USER = 1;

    public function listBadgesAction($userId)
    {
        $listBadgesCommand = $this->buildListBadgesCommandByRequest($userId);

        $badgesResources = $this->container->get(
            "gamification.interactor.command_handler.list_badges.list_badges_command_handler"
        )->handle($listBadgesCommand);

        return $this->renderHtmlResult($userId, $badgesResources);
    }

    /**
     * @param string $userId
     *
     * @return ListBadgesCommand
     */
    private function buildListBadgesCommandByRequest($userId)
    {
        return new ListBadgesCommand($userId);
    }

    /**
     * @param string $userId
     * @param BadgeResource[] $badgesResources
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderHtmlResult($userId, $badgesResources)
    {
        return $this->render(
            'GamificationWebBundle::badges.list.html.twig',
            [
                'userId' => $userId,
                'badges' => $this->buildBadgesResourcesAsArray($badgesResources)
            ]
        );
    }

    /**
     * @param BadgeResource[] $badgesResources
     *
     * @return array
     */
    private function buildBadgesResourcesAsArray($badgesResources)
    {
        $badgesResourcesAsArray = [];
        foreach ($badgesResources as $badgeResource) {
            $badgesResourcesAsArray[] = $this->buildBadgeResourceAsArray($badgeResource);
        }

        return $badgesResourcesAsArray;
    }

    /**
     * @param BadgeResource $badgeResource
     *
     * @return array
     */
    private function buildBadgeResourceAsArray(BadgeResource $badgeResource)
    {
        return [
            'name'          => $badgeResource->name(),
            'description'   => $badgeResource->description(),
            'isMultiUser'   => ($badgeResource->isMultiUser() == static::IS_MULTI_USER) ? 'Yes' : 'No',
            'imageHref'     => $badgeResource->imageResource()->href()
        ];
    }
}
