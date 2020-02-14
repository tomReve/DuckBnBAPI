<?php

namespace App\Controller;

use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractFOSRestController
{
    /**
     * @var $userRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function postUserLoginAction($email, $password)
    {
        header("Access-Control-Allow-Origin: *");
        $user = $this->userRepository->findBy(['email' => $email, 'password' => $password]);
        if($user) {
            return $user;
        } else {
            return ['message' => 'User not found with email '.$email, 'code' => 404];
        }
    }
}
