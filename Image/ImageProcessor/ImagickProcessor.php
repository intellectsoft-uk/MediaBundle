<?php

namespace SHelper\MediaBundle\Image\ImageProcessor;

class ImagickProcessor implements IImageProcessor
{
    /** @var \Imagick */
    private $image;

    /**
     * ImagickProcessor constructor.
     * @param \Imagick $image
     */
    public function __construct(\Imagick $image)
    {
        $this->image = $image;
    }

    public function __destruct()
    {
        if ($this->image) {
            $this->image->destroy();
            $this->image = null;
        }
    }

    /**
     * Get rotation angle in degrees
     *
     * @return int
     */
    public function getOrientationAngle()
    {
        $orientationToAngle = [
            \Imagick::ORIENTATION_BOTTOMRIGHT => 180,
            \Imagick::ORIENTATION_RIGHTTOP => 90,
            \Imagick::ORIENTATION_LEFTBOTTOM => -90,
        ];
        $orientation = $this->image->getImageOrientation();

        $angle = isset($orientationToAngle[$orientation]) ? $orientationToAngle[$orientation] : 0;

        return $angle;
    }


    /**
     * @return $this
     */
    public function stripImage()
    {
        $this->image->stripImage();

        return $this;
    }

    /**
     * @return $this
     */
    public function normalize()
    {
        $angle = $this->getOrientationAngle();
        $this->stripImage();

        if ($angle) {
            $this->image->rotateImage(new \ImagickPixel('none'), $angle);
        }

        return $this;
    }

    /**
     * Add set interlace scheme (progressive), set orientation, and jpeg format
     * @return $this
     */
    public function prettify()
    {
        $this->image->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
        $this->image->setImageFormat('jpeg');
        $this->image->setInterlaceScheme(\Imagick::INTERLACE_PLANE);

        return $this;
    }

    /**
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function resizeAndCropImage($width = 1024, $height = 720)
    {
        $geo = $this->image->getImageGeometry();

        if (($geo['width'] / $width) < ($geo['height'] / $height)) {
            $h = floor($height * $geo['width'] / $width);
            $y = ($geo['height'] - ($height * $geo['width'] / $width)) / 2;
            $this->image->cropImage($geo['width'], $h, 0, $y);
        } else {
            $w = ceil($width * $geo['height'] / $height);
            $x = ($geo['width'] - ($width * $geo['height'] / $height)) / 2;
            $this->image->cropImage($w, $geo['height'], $x, 0);
        }

        $this->image->ThumbnailImage($width, $height);

        return $this;
    }

    /**
     * @param string $fileName
     * @return $this
     */
    public function save($fileName)
    {
        $this->image->writeImage($fileName);

        return $this;
    }

    /**
     * @return string
     */
    public function getImageBlob()
    {
        return $this->image->getImageBlob();
    }
}
