<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(SerializerInterface $serializer, UserService $userService)
    {
        $this->serializer = $serializer;
        $this->userService = $userService;
    }

    /**
     * @Route("/user", methods={"GET"})
     */
    public function getThisUserAction()
    {
        return $this->json(['user' => $this->getUser()]);
    }

    /**
     * @Route("/users/{user}", methods={"GET"})
     */
    public function getUserAction(User $user)
    {
        return $this->json(['user' => $user]);
    }

//    /**
//     * @Route("/user/{user}/card", methods={"POST"})
//     */
//    public function addCardAction(Request $request, User $user)
//    {
//        $json = $request->getContent();
//
//        /** @var Card $card */
//        $card = $this->serializer->deserialize($json, Card::class, 'json');
//
//        $this->userService->saveCC($user, $card);
//
//        return $this->json([]);
//    }
}
