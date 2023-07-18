<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\DTO\UserSearchDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'get_user', methods: 'GET')]
    public function userList(UserRepository $userRepository,  #[MapQueryString] UserSearchDTO $request): JsonResponse
    {
        $usersPage = $userRepository->search(isset($request->page) ? (int) $request->page : 1, 10, isset($request->username) ? $request->username : null);
        return $this->json($usersPage);
    }
    #[Route('/api/user/{name}', name: 'get_user_name', methods: ['GET'])]
    public function getUserName(string $name, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['login' => $name]);
        return $this->json(['ok' => isset($user) ? true : false, 'user' => $user]);
    }
}
