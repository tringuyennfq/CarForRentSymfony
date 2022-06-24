<?php

namespace App\Controller\API\Mail;

use App\Service\MailService;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    use JsonResponseTrait;
    /**
     * @throws \PHPMailer\PHPMailer\Exception
     */
    #[Route('/api/mail', name: 'api_mail')]
    public function index(MailService $mailService): Response
    {
        $result = $mailService->sendMail('thang.duong@nfq.asia');
        return $this->success($result);
    }
}
