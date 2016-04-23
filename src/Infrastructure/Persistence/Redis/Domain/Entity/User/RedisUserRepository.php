<?php

namespace Infrastructure\Persistence\Redis\Domain\Entity\User;

use Domain\Entity\User\User;
use Domain\Entity\User\UserRepository;
use Predis\Client;

class RedisUserRepository implements UserRepository
{
    const REDIS_KEY_USER_PREFIX = "USER_";

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
    public function find($id)
    {
        return $this->retrieveUser(static::REDIS_KEY_USER_PREFIX . $id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByUserName($userName)
    {
        return $this->retrieveUser(static::REDIS_KEY_USER_PREFIX . $userName);
    }

    /**
     * {@inheritdoc}
     */
    public function findByEmail($email)
    {
        return $this->retrieveUser(static::REDIS_KEY_USER_PREFIX . $email);
    }

    /**
     * {@inheritdoc}
     */
    public function persist(User $user)
    {
        $this->storeUserById($user);
        $this->storeUserByEmail($user);
        $this->storeUserByUserName($user);
    }

    /**
     * @param User $user
     */
    private function storeUserById(User $user)
    {
        $userKeyById = static::REDIS_KEY_USER_PREFIX . $user->id();
        $this->storeUser($userKeyById, $user);
    }

    /**
     * @param User $user
     */
    private function storeUserByEmail(User $user)
    {
        $userKeyByEmail = static::REDIS_KEY_USER_PREFIX . $user->email();
        $this->storeUser($userKeyByEmail, $user);
    }

    /**
     * @param User $user
     */
    private function storeUserByUserName(User $user)
    {
        $userKeyByUserName  = static::REDIS_KEY_USER_PREFIX . $user->userName();
        $this->storeUser($userKeyByUserName, $user);
    }

    /**
     * @param string $key
     *
     * @param User $user
     */
    private function storeUser($key, User $user)
    {
        $this->client->set($key, serialize($user));
    }

    /**
     * @param string $key
     *
     * @return User | null
     */
    private function retrieveUser($key)
    {
        $userInfo = $this->client->get($key);

        if (!$userInfo) {
            return null;
        }

        return unserialize($userInfo);
    }
}
