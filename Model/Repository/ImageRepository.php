<?php

namespace SHelper\MediaBundle\Model\Repository;

use SHelper\MediaBundle\Model\Entity\Image;
use SHelper\MediaBundle\Model\Repository\Interfaces\IImageRepository;
use Doctrine\ORM\EntityRepository;

class ImageRepository extends EntityRepository implements IImageRepository
{
    /**
     * @param Image $image
     * @return $this
     */
    public function persistImage(Image $image)
    {
        $this->_em->persist($image);

        return $this;
    }
}
