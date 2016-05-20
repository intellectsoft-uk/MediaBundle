<?php

namespace SHelper\MediaBundle\Model\Repository\Interfaces;

use SHelper\MediaBundle\Model\Entity\Image;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\Common\Collections\Selectable;

Interface IImageRepository extends ObjectRepository, Selectable
{
    /**
     * @param Image $image
     * @return $this
     */
    public function persistImage(Image $image);
}
