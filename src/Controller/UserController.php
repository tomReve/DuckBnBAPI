<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var $userRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/api/user/login/{email}/{password}", name="login")
     */
    public function getUserLoginAction($email, $password)
    {
        header("Access-Control-Allow-Origin: *");
        $user = $this->userRepository->findBy(['email' => $email, 'password' => $password]);
        if($user) {
            return $this->json(
                [
                    'id' => $user[0]->getId(),
                    'pseudo' => $user[0]->getPseudo(),
                    'email' => $user[0]->getEmail()
                ]
            );
        } else {
            return $this->json(['message' => "L'utilisateur n'a pas été trouvé ".$email, 'code' => 404]);
        }
    }

    /**
     * @Route("/api/user/register/{pseudo}/{email}/{password}", name="register")
     */
    public function getUserRegisterAction($pseudo, $email, $password)
    {
        header("Access-Control-Allow-Origin: *");
        $manager = $this->getDoctrine()->getManager();

        if($this->userRepository->findBy(['email' => $email])) {
            return $this->json(['message' => "Cette email n'est pas disponible, veuillez utilier un autre email", 'code' => 444]);
        } else {
            try {
                $user = new User();
                $user->setEmail($email)
                    ->setPseudo($pseudo)
                    ->setPassword($password)
                    ->setCreatedAt(new \DateTime());

                $manager->persist($user);
                $manager->flush();
                return $this->json($user);

            } catch (\Exception $e) {
                return $this->json(['message' => $e->getMessage(), 'code' => 500]);
            }
        }
    }
}
