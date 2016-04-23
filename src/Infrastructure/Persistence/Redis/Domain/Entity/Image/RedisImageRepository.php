<?php

namespace Infrastructure\Persistence\Redis\Domain\Entity\Image;

use Domain\Entity\Image\Image;
use Domain\Entity\Image\ImageRepository;
use Predis\Client;

class RedisImageRepository implements ImageRepository
{
    const REDIS_KEY_IMAGE_PREFIX = "IMAGE_";

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
    public function persist(Image $image)
    {
        $this->storeImage(
            static::REDIS_KEY_IMAGE_PREFIX . $image->id(),
            $image
        );
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $this->retrieveImage(static::REDIS_KEY_IMAGE_PREFIX . $id);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Image $image)
    {
        $this->client->del([
            static::REDIS_KEY_IMAGE_PREFIX . $image->id()
        ]);
    }

    /**
     * @param string $key
     *
     * @param Image $image
     */
    private function storeImage($key, Image $image)
    {
        $this->client->set($key, serialize($image));
    }

    /**
     * @param string $key
     *
     * @return Image | null
     */
    private function retrieveImage($key)
    {
        $userInfo = $this->client->get($key);

        if (!$userInfo) {
            return null;
        }

        return unserialize($userInfo);
    }
}
