<?php

namespace App\Controller;

use App\Request\UploadImageRequest;
use App\Service\ImageService;
use App\Traits\JsonResponseTrait;
use App\Transformer\ImageTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FileController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[Route('/file', name: 'app_file',methods: 'POST')]
//    #[IsGranted('ROLE_ADMIN')]
    public function uploadImage(
        ImageService $imageService,
        Request $request,
        ImageTransformer $imageTransformer,
        UploadImageRequest $uploadImageRequest,
        ValidatorInterface $validator,
    ): JsonResponse
    {
        $file = $request->files->get('image');
        $uploadImageRequest->setImage($file);
        $errors = $validator->validate($uploadImageRequest);
        if (count($errors) > 0) {
            return $this->error($this->getValidationErrors($errors));
        }
        $image = $imageService->upload($file);
        return $this->success($imageTransformer->toArray($image),Response::HTTP_CREATED);
    }
}
