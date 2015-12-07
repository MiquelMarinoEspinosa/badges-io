<?php

namespace Domain\Image;

use Domain\Image\Validator\ImageValidator;

class Image
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $name;
    /** @var  int */
    private $width;
    /** @var  int */
    private $height;
    /** @var  string */
    private $format;

    public function __construct($id, $name, $width, $height, $format)
    {
        $this->setId($id)
             ->setName($name)
             ->setWidth($width)
             ->setHeight($height)
             ->setFormat($format)
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
     * @return Image
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
     * @param string $imageName
     *
     * @return Image
     */
    private function setName($imageName)
    {
        $this->name = $imageName;

        return $this;
    }

    /**
     * @return int
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * @param int $imageWidth
     *
     * @return Image
     */
    private function setWidth($imageWidth)
    {
        $this->width = $imageWidth;

        return $this;
    }

    /**
     * @return int
     */
    public function height()
    {
        return $this->height;
    }

    /**
     * @param int $imageHeight
     *
     * @return Image
     */
    private function setHeight($imageHeight)
    {
        $this->height = $imageHeight;

        return $this;
    }

    /**
     * @return string
     */
    public function format()
    {
        return $this->format;
    }

    /**
     * @param string $format
     *
     * @return Image
     */
    private function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    private function validate()
    {
        $this->buildValidator()->validate();
    }

    /**
     * @return ImageValidator
     */
    private function buildValidator()
    {
        return new ImageValidator($this);
    }
}
