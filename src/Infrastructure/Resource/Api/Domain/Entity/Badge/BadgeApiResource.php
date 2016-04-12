<?php

namespace Infrastructure\Resource\Api\Domain\Entity\Badge;

use Infrastructure\Resource\Api\Domain\Entity\Image\ImageApiResource;
use Infrastructure\Resource\Api\Domain\Entity\User\UserApiResource;

class BadgeApiResource
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $description;
    /** @var  bool */
    private $isMultiUser;
    /** @var UserApiResource */
    private $userResource;
    /** @var ImageApiResource */
    private $imageResource;

    public function __construct(
        $id,
        $name,
        $description,
        $isMultiUser,
        UserApiResource $userApiResource,
        ImageApiResource $imageResource
    ) {
        $this->setId($id)
             ->setName($name)
             ->setDescription($description)
             ->setIsMultiUser($isMultiUser)
             ->setUserResource($userApiResource)
             ->setImageResource($imageResource);
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return BadgeApiResource
     */
    private function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return BadgeApiResource
     */
    private function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return BadgeApiResource
     */
    private function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isMultiUser()
    {
        return $this->isMultiUser;
    }

    /**
     * @param boolean $isMultiUser
     *
     * @return BadgeApiResource
     */
    private function setIsMultiUser($isMultiUser)
    {
        $this->isMultiUser = $isMultiUser;

        return $this;
    }

    /**
     * @return UserApiResource
     */
    public function userResource()
    {
        return $this->userResource;
    }

    /**
     * @param UserApiResource $userResource
     *
     * @return BadgeApiResource
     */
    private function setUserResource(UserApiResource $userResource)
    {
        $this->userResource = $userResource;

        return $this;
    }

    /**
     * @return ImageApiResource
     */
    public function imageResource()
    {
        return $this->imageResource;
    }

    /**
     * @param ImageApiResource $imageResource
     *
     * @return BadgeApiResource
     */
    private function setImageResource(ImageApiResource $imageResource)
    {
        $this->imageResource = $imageResource;

        return $this;
    }
}
