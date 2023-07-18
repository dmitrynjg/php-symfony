<?php

namespace App\Controller;

use App\Repository\RequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use App\DTO\RequestCreateDTO;
use App\DTO\RequestGetDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Entity\User;

class RequestController extends AbstractController
{
    #[Route('/api/request', name: 'get_request', methods: ['GET'], defaults: array('foo' => 'bar'))]
    public function getRequest(#[MapQueryString] RequestGetDTO $request, RequestRepository $requestRepository): JsonResponse
    {
        $reqeusts = $requestRepository->search(isset($request->page) ? (int) $request->page : 1, 3);
        return $this->json($reqeusts);
    }

    #[Route('/api/request', name: 'create_request', methods: ['POST'])]
    public function createRequest(#[MapRequestPayload] RequestCreateDTO $request = new RequestCreateDTO(), EntityManagerInterface $entityManager, RequestRepository $requestRepository): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->find($request->userId);
       
        if (!$user || !isset($user)) {
            throw new BadRequestHttpException('Пользователь не найден');
        }
        $requestRepository->create($user, $request->text, $entityManager);
        return $this->json([
            'ok' => true,
            'message' => 'Заявка создана',
        ]);
    }
}
