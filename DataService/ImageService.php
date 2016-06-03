<?php

namespace SHelper\MediaBundle\DataService;

use SHelper\MediaBundle\DataService\Interfaces\IImageService;
use SHelper\MediaBundle\Image\ImageProcessor\Factory\IImageFactory;
use SHelper\MediaBundle\Image\ImageProcessor\IImageProcessor;
use SHelper\MediaBundle\Model\Entity\Image;
use SHelper\MediaBundle\Model\Repository\Interfaces\IImageRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageService implements IImageService
{
    /** @var IImageFactory */
    protected $imageProcessorFactory;

    /** @var IImageRepository */
    protected $imageRepository;

    /** @var string */
    protected $webRoot;

    /** @var string */
    protected $host;

    /** @var array */
    protected $resolutionConfig;

    protected $defaultResolution = [
        'width' => 200,
        'height' => 200,
    ];

    /**
     * @param IImageRepository $imageRepository
     * @param IImageFactory $imageFactory
     * @param string $root
     * @param string $host
     * @param int[] $resolutionConfig
     */
    public function __construct(IImageRepository $imageRepository, IImageFactory $imageFactory, $root, $host, array $resolutionConfig)
    {
        $this->imageRepository = $imageRepository;
        $this->imageProcessorFactory = $imageFactory;

        //TODO:: move it to storage service
        $this->webRoot = realpath($root . '/../web');
        $this->host = $host;

        $this->resolutionConfig = $resolutionConfig;
    }

    /**
     * @param string $ext
     * @return string
     */
    protected function generateFileName($ext = 'jpg')
    {
        //TODO:: move it to storage service
        $fileName = md5(rand());
        $folder = substr($fileName, 0, 2) . DIRECTORY_SEPARATOR . substr($fileName, 2, 2);

        $folder = $this->webRoot . '/media/image/' . $folder;
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        $result = $folder . DIRECTORY_SEPARATOR . $fileName . '.' . $ext;

        return $result;
    }

    /**
     * @param IImageProcessor $imageProcessor
     * @param string $outputFileName
     * @param int $width
     * @param int $height
     * @return $this
     */
    protected function prepareImage(IImageProcessor $imageProcessor, $outputFileName, $width = 172, $height = 172)
    {
        $imageProcessor
            ->normalize()
            ->resizeAndCropImage($width, $height)
            ->prettify()
            ->save($outputFileName);

//        unset($imageProcessor);

        return $this;
    }

    /**
     * @param \SplFileInfo $file
     * @return Image
     */
    public function createImageFromFile(\SplFileInfo $file)
    {
        //TODO: implement this method
//        $outputFileName = $this->generateFileName();
//        $imageProcessor = $this->imageProcessorFactory->createFromFile($file);
//        $this->prepareImage($imageProcessor, $outputFileName);
//        @unlink($file->getFilename());
//
//
//        //TODO:: move it to storage service
//        $url = str_replace($this->webRoot . '/', 'http://' . $this->host . '/', $outputFileName);
//
//        $image = new Image();
//        $image->setUrl($url);
////        $image->setPreview([
////            'thumbnail' => $thumbFileName,
////        ]);
//
//        $this->imageRepository->persistImage($image);
//
//        return $image;
    }

    /**
     * @param Image $image
     * @param \SplFileInfo $file
     * @return Image
     */
    public function updateImageFromFile(Image $image, \SplFileInfo $file)
    {
        //TODO: implement this method
//        $oldUrl = $image->getUrl();
//
//        $outputFileName = $this->generateFileName();
//        $imageProcessor = $this->imageProcessorFactory->createFromFile($file);
//        $this->prepareImage($imageProcessor, $outputFileName);
//        @unlink($file->getFilename());
//
//        //TODO:: move it to storage service
//        $url = str_replace($this->webRoot . '/', 'http://' . $this->host . '/', $outputFileName);
//        $image->setUrl($url);
//
//        $this->imageRepository->persistImage($image);
//
//        $oldPath = str_replace('http://' . $this->host . '/', $this->webRoot . '/', $oldUrl);
//        @unlink($oldPath);
//
//        return $image;
    }


    /**
     * @return array
     */
    protected function getOriginalResolution()
    {
        return array_merge($this->defaultResolution, $this->resolutionConfig['original_resolution']);
    }

    /**
     * @param string $imageBlob
     * @return Image
     */
    public function createImageFromBlob($imageBlob)
    {
        $originalFileName = $this->generateFileName();
        $originalProcessor = $this->imageProcessorFactory->createFromBlob($imageBlob);

        $originalRes = $this->getOriginalResolution();
        $this->prepareImage($originalProcessor, $originalFileName, $originalRes['width'], $originalRes['height']);

        $previews = [];
        foreach ($this->resolutionConfig['previews'] as $previewKey => $previewResolution) {
            $previewResolution = array_merge($this->defaultResolution, $previewResolution);

            $previewFileName = $this->generateFileName();
            $previewProcessor = $this->imageProcessorFactory->createFromBlob($originalProcessor->getImageBlob());
            //TODO: remove resolution hardcode
            $this->prepareImage($previewProcessor, $previewFileName, $previewResolution['width'], $previewResolution['height']);

            unset($thumbProcessor);

            $previewUrl = str_replace($this->webRoot . '/', 'http://' . $this->host . '/', $previewFileName);
            $previews[$previewKey] = $previewUrl;
        }

        unset($originalProcessor);

        //TODO:: move it to storage service
        $originalUrl = str_replace($this->webRoot . '/', 'http://' . $this->host . '/', $originalFileName);


        $image = new Image();
        $image->setUrl($originalUrl);
        $image->setPreview($previews);

        $this->imageRepository->persistImage($image);

        return $image;
    }

    /**
     * @param Image $image
     * @param string $imageBlob
     * @return Image
     */
    public function updateImageFromBlob(Image $image, $imageBlob)
    {
        $oldOriginalUrl = $image->getUrl();
        $oldPreviews = $image->getPreview();
        $thumbnailUrl = isset($oldPreviews['thumbnail']) ? $oldPreviews['thumbnail'] : null;

        $originalFileName = $this->generateFileName();
        $originalProcessor = $this->imageProcessorFactory->createFromBlob($imageBlob);
        $this->prepareImage($originalProcessor, $originalFileName);

        $thumbFileName = $this->generateFileName();
        $thumbProcessor = $this->imageProcessorFactory->createFromBlob($originalProcessor->getImageBlob());
        //TODO: remove resolution hardcode
        $this->prepareImage($thumbProcessor, $thumbFileName, 52, 52);

        unset($originalProcessor);
        unset($thumbProcessor);

        //TODO:: move it to storage service
        $originalUrl = str_replace($this->webRoot . '/', 'http://' . $this->host . '/', $originalFileName);
        $thumbUrl = str_replace($this->webRoot . '/', 'http://' . $this->host . '/', $thumbFileName);

        $image->setUrl($originalUrl);
        $image->setPreview([
            'thumbnail' => $thumbUrl,
        ]);
        $this->imageRepository->persistImage($image);

        $oldOriginalPath = str_replace('http://' . $this->host . '/', $this->webRoot . '/', $oldOriginalUrl);
        @unlink($oldOriginalPath);

        if ($thumbnailUrl) {
            $oldThumbPath = str_replace('http://' . $this->host . '/', $this->webRoot . '/', $thumbnailUrl);
            @unlink($oldThumbPath);
        }

        return $image;
    }

    /**
     * @param int $imageId
     * @return Image
     * @throws NotFoundHttpException
     */
    public function findById($imageId)
    {
        if (false == $image = $this->imageRepository->find($imageId)) {
            throw new NotFoundHttpException('Image not found in DB');
        }

        return $image;
    }
}
