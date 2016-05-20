<?php

namespace SHelper\MediaBundle\Controller;

use SHelper\MediaBundle\DataService\Interfaces\IImageService;
use FOS\RestBundle\View\View;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    /**
     * @var IImageService
     * @DI\Inject("app_media.data.image_service")
     */
    private $imageService;

    /**
     * @param Request $request
     * @return View
     */
    public function createAction(Request $request)
    {
        //TODO: fix @Rest\View
        $view = View::create();
        $view->setFormat('json');
        $imageBlob = $request->getContent();
        if ($imageBlob && 'jpeg' == $request->getContentType()) {
            try {
                $image = $this->imageService->createImageFromBlob($imageBlob);
                $this->getDoctrine()->getManager()->flush();

                $view->setStatusCode(Response::HTTP_CREATED);
                $view->setData($image);
            } catch (\ImagickException $e) {
                $view->setData(['message' => 'Invalid or unsupported image file format']);
                $view->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            $view->setData(['message' => 'Image file can\'t be processed, please retry or upload a different file']);
            $view->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $view;
    }

    /**
     * @param int $imageId
     * @param Request $request
     * @return View
     */
    public function updateAction($imageId, Request $request)
    {
        $image = $this->imageService->findById($imageId);

        //TODO: fix @Rest\View
        $view = View::create();
        $view->setFormat('json');

        $imageBlob = $request->getContent();
        if ($imageBlob && 'jpeg' == $request->getContentType()) {
            try {
                $image = $this->imageService->updateImageFromBlob($image, $imageBlob);
                $this->getDoctrine()->getManager()->flush();

                $view->setStatusCode(Response::HTTP_CREATED);
                $view->setData($image);
            } catch (\ImagickException $e) {
                $view->setData(['message' => 'Invalid or unsupported image file format']);
                $view->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {
            $view->setData(['message' => 'Image file can\'t be processed, please retry or upload a different file']);
            $view->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $view;
    }
}
