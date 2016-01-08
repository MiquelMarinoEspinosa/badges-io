<?php

namespace Interactor\CommandHandler\GetBadge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandHandlerException;
use Interactor\CommandHandler\GetBadge\Exception\InvalidGetBadgeCommandHandlerExceptionCode;

class GetBadgeCommandHandler implements CommandHandler
{
    /**
     * @var BadgeRepository
     */
    private $badgeRepository;

    /**
     * @var BadgeDataTransformer
     */
    private $badgeDataTransformer;

    public function __construct(
        BadgeRepository $badgeRepository,
        BadgeDataTransformer $badgeDataTransformer
    ) {
        $this->badgeRepository      = $badgeRepository;
        $this->badgeDataTransformer = $badgeDataTransformer;
    }

    /**
     * @param GetBadgeCommand $command
     *
     * @return mixed
     */
    public function handle($command)
    {
        $badge = $this->tryToFindBadge($command->badgeId());
        $this->validateBadge($badge, $command->tenantId());

        return $this->badgeDataTransformer->transform($badge);
    }

    /**
     * @param string $badgeId
     *
     * @return Badge
     * @throws InvalidGetBadgeCommandHandlerException
     */
    private function tryToFindBadge($badgeId)
    {
        $aNullBadge = null;
        try {
            $badge = $this->badgeRepository->find($badgeId);
        } catch (\Exception $exception) {
            throw $this->buildGetBadgeCommandHandlerException(
                InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND
            );
        }

        if ($aNullBadge === $badge) {
            throw $this->buildGetBadgeCommandHandlerException(
                InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_BADGE_NOT_FOUND
            );
        }

        return $badge;
    }

    /**
     * @param Badge $badge
     * @param string $tenantId
     *
     * @throws InvalidGetBadgeCommandHandlerException
     */
    private function validateBadge(Badge $badge, $tenantId)
    {
        $isNotMultiTenant = false;
        if ($badge->isMultiTenant() === $isNotMultiTenant && $this->notValidTenant($badge, $tenantId)) {
            throw $this->buildGetBadgeCommandHandlerException(
                InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_TENANT_FORBIDDEN
            );
        }
    }

    /**
     * @param Badge $badge
     * @param string $tenantId
     *
     * @return bool
     */
    private function notValidTenant(Badge $badge, $tenantId)
    {
        return $badge->tenant()->id() !== $tenantId;
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidGetBadgeCommandHandlerException
     */
    private function buildGetBadgeCommandHandlerException($statusCode)
    {
        return new InvalidGetBadgeCommandHandlerException($statusCode);
    }
}
