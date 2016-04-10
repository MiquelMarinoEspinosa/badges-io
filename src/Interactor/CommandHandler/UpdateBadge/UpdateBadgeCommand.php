<?php

namespace Interactor\CommandHandler\UpdateBadge;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\UpdateBadge\ImageData\ImageData;
use Interactor\CommandHandler\UpdateBadge\UserData\UserData;
use Interactor\CommandHandler\UpdateBadge\Validator\UpdateBadgeCommandValidator;

class UpdateBadgeCommand extends BaseCommand
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $description;
    /** @var  bool */
    private $isMultiUser;
    /** @var  UserData */
    private $userData;
    /** @var  ImageData */
    private $imageData;

    public function __construct($id, $name, $description, $isMultiUser, UserData $userData, ImageData $imageData)
    {
        $this->setId($id)
             ->setName($name)
             ->setDescription($description)
             ->setIsMultiUser($isMultiUser)
             ->setUserData($userData)
             ->setImageData($imageData)
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
     * @return UpdateBadgeCommand
     */
    public function setId($id)
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
     * @return UpdateBadgeCommand
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
     * @return UpdateBadgeCommand
     */
    private function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return UserData
     */
    public function userData()
    {
        return $this->userData;
    }

    /**
     * @param UserData $userData
     *
     * @return UpdateBadgeCommand
     */
    private function setUserData($userData)
    {
        $this->userData = $userData;

        return $this;
    }

    /**
     * @return ImageData
     */
    public function imageData()
    {
        return $this->imageData;
    }

    /**
     * @param ImageData $imageData
     *
     * @return UpdateBadgeCommand
     */
    private function setImageData($imageData)
    {
        $this->imageData = $imageData;

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
     * @return UpdateBadgeCommand
     */
    private function setIsMultiUser($isMultiUser)
    {
        $this->isMultiUser = $isMultiUser;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function buildValidator()
    {
        return new UpdateBadgeCommandValidator($this);
    }
}
