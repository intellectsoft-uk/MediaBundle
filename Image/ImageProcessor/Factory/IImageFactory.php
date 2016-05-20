<?php

namespace SHelper\MediaBundle\Image\ImageProcessor\Factory;

use SHelper\MediaBundle\Image\ImageProcessor\IImageProcessor;

interface IImageFactory
{
    /**
     * @param string $imageBlob
     * @return IImageProcessor
     */
    public function createFromBlob($imageBlob);

    /**
     * @param \SplFileInfo $file
     * @return IImageProcessor
     */
    public function createFromFile(\SplFileInfo $file);

}
