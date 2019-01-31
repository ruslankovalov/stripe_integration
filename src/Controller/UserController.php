<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\Card;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
     * @Route("/user/{user}/card", methods={"POST"})
     */
    public function addCardAction(Request $request, User $user)
    {
        $json = $request->getContent();

        /** @var Card $card */
        $card = $this->serializer->deserialize($json, Card::class, 'json');

        $this->userService->saveCC($user, $card);

        return $this->json([]);
    }
}
