<?php

namespace App\Bundle\GamificationApiBundle\Controller\ApiKeyAuthentication\EventListener;

use App\Bundle\GamificationApiBundle\Controller\ApiKeyAuthentication\ApiKeyAuthenticatedController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ApiKeyListener
{
    /** @var string  */
    private $apiKey;

    /**
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function onKernelController(FilterControllerEvent $event)
    {

        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof ApiKeyAuthenticatedController) {
            $apiKey = $event->getRequest()->headers->get("apiKey");

            if ($apiKey !== $this->apiKey) {
                throw new AccessDeniedHttpException('This action needs a valid api key!');
            }
        }
    }
}
