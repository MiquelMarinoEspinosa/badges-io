<?php

namespace Infrastructure\Resource\Domain\Entity\Image;

class ImageResource
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
    /** @var  string */
    private $href;

    public function __construct($id, $name, $width, $height, $format, $href)
    {
        $this->setId($id)
             ->setName($name)
             ->setWidth($width)
             ->setHeight($height)
             ->setFormat($format)
             ->setHref($href);
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
     * @return ImageResource
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
     * @return ImageResource
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
     * @return ImageResource
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
     * @return ImageResource
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
     * @return ImageResource
     */
    private function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return string
     */
    public function href()
    {
        return $this->href;
    }

    /**
     * @param string $href
     *
     * @return ImageResource
     */
    private function setHref($href)
    {
        $this->href = $href;

        return $this;
    }
}
