<?php

namespace Infrastructure\Resource\Domain\Entity\Badge;

use Infrastructure\Resource\Domain\Entity\Image\ImageResource;
use Infrastructure\Resource\Domain\Entity\User\UserResource;

class BadgeResource
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $description;
    /** @var  bool */
    private $isMultiUser;
    /** @var UserResource */
    private $userResource;
    /** @var ImageResource */
    private $imageResource;

    public function __construct(
        $id,
        $name,
        $description,
        $isMultiUser,
        UserResource $userResource,
        ImageResource $imageResource
    ) {
        $this->setId($id)
             ->setName($name)
             ->setDescription($description)
             ->setIsMultiUser($isMultiUser)
             ->setUserResource($userResource)
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
     * @return BadgeResource
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
     * @return BadgeResource
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
     * @return BadgeResource
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
     * @return BadgeResource
     */
    private function setIsMultiUser($isMultiUser)
    {
        $this->isMultiUser = $isMultiUser;

        return $this;
    }

    /**
     * @return UserResource
     */
    public function userResource()
    {
        return $this->userResource;
    }

    /**
     * @param UserResource $userResource
     *
     * @return BadgeResource
     */
    private function setUserResource(UserResource $userResource)
    {
        $this->userResource = $userResource;

        return $this;
    }

    /**
     * @return ImageResource
     */
    public function imageResource()
    {
        return $this->imageResource;
    }

    /**
     * @param ImageResource $imageResource
     *
     * @return BadgeResource
     */
    private function setImageResource(ImageResource $imageResource)
    {
        $this->imageResource = $imageResource;

        return $this;
    }
}
