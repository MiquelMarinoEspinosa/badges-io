<?php

namespace Interactor\CommandHandler\ListBadges;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeCollectionDataTransformer;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;
use Interactor\CommandHandler\CommandHandler;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerException;
use Interactor\CommandHandler\ListBadges\Exception\InvalidListBadgesCommandHandlerExceptionCode;

class ListBadgesCommandHandler implements CommandHandler
{
    /**
     * @var BadgeRepository
     */
    private $badgeRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var BadgeCollectionDataTransformer
     */
    private $badgeCollectionDataTransformer;

    public function __construct(
        BadgeRepository                $badgeRepository,
        UserRepository                 $userRepository,
        BadgeCollectionDataTransformer $badgeCollectionDataTransformer
    ) {
        $this->badgeRepository                = $badgeRepository;
        $this->userRepository                 = $userRepository;
        $this->badgeCollectionDataTransformer = $badgeCollectionDataTransformer;
    }

    /**
     * @param ListBadgesCommand $command
     *
     * @return mixed
     */
    public function handle($command)
    {
        $badgesByUser    = $this->tryToFindBadgesByUser($command->userId());
        $badgesMultiUser = $this->tryToFindMultiUserBadges();

        return $this->badgeCollectionDataTransformer->transform(
            $this->mixBadgesResult(
                $badgesByUser,
                $badgesMultiUser
            )
        );
    }

    /**
     * @param string $userId
     *
     * @return Badge[]
     * @throws InvalidListBadgesCommandHandlerException
     */
    private function tryToFindBadgesByUser($userId)
    {
        $user = $this->tryToFindUserByUserId($userId);
        try {
            $badgesByUser = $this->badgeRepository->findByUser($user);
        } catch (\Exception $exception) {
            throw $this->buildListBadgesCommandHandlerException(
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }

        return $badgesByUser;
    }

    /**
     * @param string $userId
     *
     * @return User
     * @throws InvalidListBadgesCommandHandlerException
     */
    private function tryToFindUserByUserId($userId)
    {
        $aNullUser = null;
        try {
            $user = $this->userRepository->find($userId);
        } catch (\Exception $exception) {
            throw $this->buildListBadgesCommandHandlerException(
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }

        if ($aNullUser === $user) {
            throw $this->buildListBadgesCommandHandlerException(
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_USER_NOT_FOUND
            );
        }

        return $user;
    }

    /**
     * @return Badge[]
     * @throws InvalidListBadgesCommandHandlerException
     */
    private function tryToFindMultiUserBadges()
    {
        try {
            $badgesMultiUser = $this->badgeRepository->findMultiUser();
        } catch (\Exception $exception) {
            throw $this->buildListBadgesCommandHandlerException(
                InvalidListBadgesCommandHandlerExceptionCode::STATUS_CODE_BADGES_NOT_FOUND
            );
        }

        return $badgesMultiUser;
    }

    /**
     * @param Badge[] $badgesByUser
     * @param Badge[] $badgesMultiUser
     *
     * @return array
     */
    private function mixBadgesResult($badgesByUser, $badgesMultiUser)
    {
        $badgesByUserIds        = $this->extractBadgesByUserIds($badgesByUser);
        $uniqueBadgesMultiUser  = $this->extractUniqueBadgesMultiUser($badgesMultiUser, $badgesByUserIds);

        return array_merge($badgesByUser, $uniqueBadgesMultiUser);
    }

    /**
     * @param Badge[] $badgesByUser
     *
     * @return array
     */
    private function extractBadgesByUserIds($badgesByUser)
    {
        $badgesByUserIds = [];

        foreach ($badgesByUser as $badgeByUser) {
            $badgesByUserIds[] = $badgeByUser->id();
        }

        return $badgesByUserIds;
    }

    /**
     * @param Badge[] $badgesMultiUser
     * @param array $badgesByUserIds
     *
     * @return array
     */
    private function extractUniqueBadgesMultiUser($badgesMultiUser, $badgesByUserIds)
    {
        $badgeMultiUserHasToInclude = [];
        foreach ($badgesMultiUser as $badgeMultiUser) {
            if ($this->isTheBadgeUnique($badgesByUserIds, $badgeMultiUser)) {
                $badgeMultiUserHasToInclude[] = $badgeMultiUser;
            }
        }

        return $badgeMultiUserHasToInclude;
    }

    /**
     * @param array $badgesByUserIds
     * @param Badge $badgeMultiUser
     *
     * @return bool
     */
    private function isTheBadgeUnique($badgesByUserIds, $badgeMultiUser)
    {
        return !in_array($badgeMultiUser->id(), $badgesByUserIds);
    }

    /**
     * @param int $statusCode
     *
     * @return InvalidListBadgesCommandHandlerException
     */
    private function buildListBadgesCommandHandlerException($statusCode)
    {
        return new InvalidListBadgesCommandHandlerException($statusCode);
    }
}
