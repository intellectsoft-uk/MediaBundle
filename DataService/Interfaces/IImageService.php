<?php

namespace SHelper\MediaBundle\DataService\Interfaces;

use SHelper\MediaBundle\Model\Entity\Image;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

interface IImageService
{
    /**
     * @param \SplFileInfo $file
     * @return Image
     */
    public function createImageFromFile(\SplFileInfo $file);

    /**
     * @param Image $image
     * @param \SplFileInfo $file
     * @return Image
     */
    public function updateImageFromFile(Image $image, \SplFileInfo $file);

    /**
     * @param string $imageBlob
     * @return Image
     */
    public function createImageFromBlob($imageBlob);

    /**
     * @param Image $image
     * @param string $imageBlob
     * @return Image
     */
    public function updateImageFromBlob(Image $image, $imageBlob);

    /**
     * @param int $imageId
     * @return Image
     * @throws NotFoundHttpException
     */
    public function findById($imageId);
}
