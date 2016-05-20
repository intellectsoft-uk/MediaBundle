<?php

namespace SHelper\MediaBundle\Image\ImageProcessor\Factory;

use SHelper\MediaBundle\Image\ImageProcessor\ImagickProcessor;

class ImagickFactory implements IImageFactory
{
    /**
     * @param string $imageBlob
     * @return ImagickProcessor
     */
    public function createFromBlob($imageBlob)
    {
        $imagick = new \Imagick();
        $imagick->readImageBlob($imageBlob);

        $image = new ImagickProcessor($imagick);

        return $image;
    }

    /**
     * @param \SplFileInfo $file
     * @return ImagickProcessor
     */
    public function createFromFile(\SplFileInfo $file)
    {
        $imagick = new \Imagick();
        $imagick->readImage($file->getRealPath());

        $image = new ImagickProcessor($imagick);

        return $image;
    }
}
