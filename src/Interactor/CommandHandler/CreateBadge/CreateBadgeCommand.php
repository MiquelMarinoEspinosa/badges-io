<?php

namespace Interactor\CommandHandler\CreateBadge;

use Interactor\CommandHandler\BaseCommand;
use Interactor\CommandHandler\CreateBadge\ImageData\ImageData;
use Interactor\CommandHandler\CreateBadge\UserData\UserData;
use Interactor\CommandHandler\CreateBadge\Validator\CreateBadgeCommandValidator;

class CreateBadgeCommand extends BaseCommand
{
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

    public function __construct($name, $description, $isMultiUser, UserData $userData, ImageData $imageData)
    {
        $this->setName($name)
             ->setDescription($description)
             ->setIsMultiUser($isMultiUser)
             ->setUserData($userData)
             ->setImageData($imageData)
             ->validate();
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
     * @return CreateBadgeCommand
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
     * @return CreateBadgeCommand
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
     * @return CreateBadgeCommand
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
     * @return CreateBadgeCommand
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
     * @return CreateBadgeCommand
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
        return new CreateBadgeCommandValidator($this);
    }
}
