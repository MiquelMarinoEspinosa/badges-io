<?php

namespace Infrastructure\Resource\Api\Domain\Entity\Image;

class ImageApiResource
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
             ->setFormat($format);
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
     * @return ImageApiResource
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
     * @return ImageApiResource
     */
    private function setName($name)
    {
        $this->name = $name;

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
     * @param int $width
     *
     * @return ImageApiResource
     */
    private function setWidth($width)
    {
        $this->width = $width;

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
     * @param int $height
     *
     * @return ImageApiResource
     */
    private function setHeight($height)
    {
        $this->height = $height;

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
     * @return ImageApiResource
     */
    private function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }
}
