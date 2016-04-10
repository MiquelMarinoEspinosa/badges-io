<?php

namespace Domain\Entity\Badge;

use Domain\Entity\Badge\Validator\BadgeValidator;
use Domain\Entity\Image\Image;
use Domain\Entity\User\User;

class Badge
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $description;
    /** @var  bool */
    private $isMultiUser;
    /** @var  User */
    private $user;
    /** @var  Image */
    private $image;

    public function __construct($id, $name, $description, $isMultiUser, User $user, Image $image)
    {
        $this->setId($id)
             ->setName($name)
             ->setDescription($description)
             ->setIsMultiUser($isMultiUser)
             ->setUser($user)
             ->setImage($image)
             ->validate();
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
     * @return Badge
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
     * @return Badge
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
     * @return Badge
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
     * @return Badge
     */
    private function setIsMultiUser($isMultiUser)
    {
        $this->isMultiUser = $isMultiUser;

        return $this;
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Badge
     */
    private function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Image
     */
    public function image()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     *
     * @return Badge
     */
    private function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    private function validate()
    {
        $this->buildValidator()->validate();
    }

    /**
     * @return BadgeValidator
     */
    private function buildValidator()
    {
        return new BadgeValidator($this);
    }
}
