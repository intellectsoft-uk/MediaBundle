<?php

namespace SHelper\MediaBundle\Serializer\Handler;

use SHelper\MediaBundle\DataService\Interfaces\IImageService;
use JMS\Serializer\JsonDeserializationVisitor;

class ImageHandler
{
    /** @var IImageService */
    private $imageService;

    /**
     * @param IImageService $imageService
     */
    public function __construct(IImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function deserializeImageFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        $clip = null;
        if (isset($data['id']) && (int)$data['id']) {
            $clip = $this->imageService->findById($data['id']);
        }

        return $clip;
    }
}
