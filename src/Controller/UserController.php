<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\Card;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(SerializerInterface $serializer, UserService $userService, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->userService = $userService;
        $this->validator = $validator;
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

    /**
     * @Route("/user/{user}/card", methods={"POST"})
     */
    public function addCardAction(Request $request, User $user)
    {
        $json = $request->getContent();

        /** @var Card $card */
        $card = $this->serializer->deserialize($json, Card::class, 'json');

        $violations = $this->validator->validate($card);
        if ($violations->count()) {
            throw new BadRequestHttpException('Invalid Card Data.');
        }

        $this->userService->saveCC($user, $card);

        return $this->json([]);
    }
}
