<?php

namespace Infrastructure\Persistence\Redis\Domain\Entity\Badge;

use Domain\Entity\Badge\Badge;
use Domain\Entity\Badge\BadgeRepository;
use Domain\Entity\User\User;
use Predis\Client;

class RedisBadgeRepository implements BadgeRepository
{
    const REDIS_KEY_BADGE_PREFIX = "BADGE_";

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function persist(Badge $badge)
    {
        $this->storeBadge(
            $this->buildBadgeCompositeKey($badge),
            $badge
        );
        $this->storeBadge(
            static::REDIS_KEY_BADGE_PREFIX . $badge->id(),
            $badge
        );
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->retrieveBadge(static::REDIS_KEY_BADGE_PREFIX . $id);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Badge $badge)
    {
        $this->client->del(
            [
                $this->buildBadgeCompositeKey($badge),
                static::REDIS_KEY_BADGE_PREFIX . $badge->id()
            ]
        );
    }

    /**
     * @param Badge $badge
     *
     * @return string
     */
    private function buildBadgeCompositeKey(Badge $badge)
    {
        $isMultiUser = ($badge->isMultiUser()) ? "YES" : "NO";

        return static::REDIS_KEY_BADGE_PREFIX .
            $badge->id() .
            "_" .
            $badge->user()->id() .
            "_" .
            $isMultiUser;
    }

    /**
     * {@inheritdoc}
     */
    public function findByUser(User $user)
    {
        $badgeKeys = $this->client->keys(static::REDIS_KEY_BADGE_PREFIX . "*" . $user->id() . "*");
        $badges = $this->retrieveByMultiKeys($badgeKeys);

        return $badges;
    }

    /**
     * {@inheritdoc}
     */
    public function findMultiUser()
    {
        $badgeKeys = $this->client->keys(static::REDIS_KEY_BADGE_PREFIX . "*" . "YES");
        $badges = $this->retrieveByMultiKeys($badgeKeys);

        return $badges;
    }

    /**
     * @param $badgeKeys
     *
     * @return Badge[]
     */
    private function retrieveByMultiKeys($badgeKeys)
    {
        $badges = [];
        foreach ($badgeKeys as $badgeKey) {
            $badge = $this->retrieveBadge($badgeKey);
            if (null !== $badge) {
                $badges[] = $badge;
            }
        }

        return $badges;
    }

    /**
     * @param string $key
     *
     * @param Badge $badge
     */
    private function storeBadge($key, Badge $badge)
    {
        $this->client->set($key, serialize($badge));
    }

    /**
     * @param string $key
     *
     * @return Badge | null
     */
    private function retrieveBadge($key)
    {
        $badgeInfo = $this->client->get($key);

        if (!$badgeInfo) {
            return null;
        }

        return unserialize($badgeInfo);
    }
}
