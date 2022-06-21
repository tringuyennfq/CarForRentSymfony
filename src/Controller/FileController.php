<?php

namespace App\Controller;

use App\Service\ImageService;
use App\Traits\JsonResponseTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    use JsonResponseTrait;
    #[Route('/file', name: 'app_file',methods: 'POST')]
    #[IsGranted('ROLE_ADMIN')]
    public function uploadImage(ImageService $imageService, Request $request): JsonResponse
    {
        $file = $request->files->get('image');
        $image = $imageService->upload($file);
        return $this->success('Image uploaded successfully',Response::HTTP_CREATED);
    }
}
