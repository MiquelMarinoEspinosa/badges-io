<?php

namespace Interactor\CommandHandler\CreateBadge\ImageData;

class ImageData
{
    /** @var  string */
    private $name;
    /** @var  int */
    private $width;
    /** @var  int */
    private $height;
    /** @var  string */
    private $format;
    /** @var  string */
    private $path;

    public function __construct($name, $width, $height, $format, $path)
    {
        $this->setName($name)
             ->setWidth($width)
             ->setHeight($height)
             ->setFormat($format)
             ->setPath($path);
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
     * @return ImageData
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
     * @return ImageData
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
     * @return ImageData
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
     * @return ImageData
     */
    private function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return ImageData
     */
    private function setPath($path)
    {
        $this->path = $path;

        return $this;
    }
}
