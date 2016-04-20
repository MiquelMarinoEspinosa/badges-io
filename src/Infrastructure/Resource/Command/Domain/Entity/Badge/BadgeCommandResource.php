<?php

namespace Infrastructure\Resource\Command\Domain\Entity\Badge;

use Infrastructure\Resource\Command\Domain\Entity\Image\ImageCommandResource;
use Infrastructure\Resource\Command\Domain\Entity\User\UserCommandResource;

class BadgeCommandResource
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $description;
    /** @var  bool */
    private $isMultiUser;
    /** @var UserCommandResource */
    private $userResource;
    /** @var ImageCommandResource */
    private $imageResource;

    public function __construct(
        $id,
        $name,
        $description,
        $isMultiUser,
        UserCommandResource $userCommandResource,
        ImageCommandResource $imageResource
    ) {
        $this->setId($id)
             ->setName($name)
             ->setDescription($description)
             ->setIsMultiUser($isMultiUser)
             ->setUserResource($userCommandResource)
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
     * @return BadgeCommandResource
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
     * @return BadgeCommandResource
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
     * @return BadgeCommandResource
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
     * @return BadgeCommandResource
     */
    private function setIsMultiUser($isMultiUser)
    {
        $this->isMultiUser = $isMultiUser;

        return $this;
    }

    /**
     * @return UserCommandResource
     */
    public function userResource()
    {
        return $this->userResource;
    }

    /**
     * @param UserCommandResource $userResource
     *
     * @return BadgeCommandResource
     */
    private function setUserResource(UserCommandResource $userResource)
    {
        $this->userResource = $userResource;

        return $this;
    }

    /**
     * @return ImageCommandResource
     */
    public function imageResource()
    {
        return $this->imageResource;
    }

    /**
     * @param ImageCommandResource $imageResource
     *
     * @return BadgeCommandResource
     */
    private function setImageResource(ImageCommandResource $imageResource)
    {
        $this->imageResource = $imageResource;

        return $this;
    }
}
