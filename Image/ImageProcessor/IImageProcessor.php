<?php

namespace SHelper\MediaBundle\Image\ImageProcessor;

interface IImageProcessor
{
    /**
     * @return $this
     */
    public function stripImage();

    /**
     * @return $this
     */
    public function normalize();

    /**
     * Get rotation angle in degrees
     * @return int
     */
    public function getOrientationAngle();

    /**
     * Add set interlace scheme (progressive), set orientation, and jpeg format
     * @return $this
     */
    public function prettify();

    /**
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function resizeAndCropImage($width = 1024, $height = 720);

    /**
     * @param string $fileName
     * @return $this
     */
    public function save($fileName);

    /**
     * @return string
     */
    public function getImageBlob();
}
