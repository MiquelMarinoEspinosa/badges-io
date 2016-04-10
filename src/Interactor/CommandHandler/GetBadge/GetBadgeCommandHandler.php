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
        $this->validateBadge($badge, $command->userId());

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
     * @param string $userId
     *
     * @throws InvalidGetBadgeCommandHandlerException
     */
    private function validateBadge(Badge $badge, $userId)
    {
        $isNotMultiUser = false;
        if ($badge->isMultiUser() === $isNotMultiUser && $this->notValidUser($badge, $userId)) {
            throw $this->buildGetBadgeCommandHandlerException(
                InvalidGetBadgeCommandHandlerExceptionCode::STATUS_CODE_USER_FORBIDDEN
            );
        }
    }

    /**
     * @param Badge $badge
     * @param string $userId
     *
     * @return bool
     */
    private function notValidUser(Badge $badge, $userId)
    {
        return $badge->user()->id() !== $userId;
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
