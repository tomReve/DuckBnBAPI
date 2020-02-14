<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use App\Repository\HousingRepository;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class BookingController extends AbstractController
{
    /**
     * @var $bookingRepository
     */
    private $bookingRepository;

    /**
     * @var $userRepository
     */
    private $userRepository;

    /**
     * @var $housingRepository
     */
    private $housingRepository;

    public function __construct(BookingRepository $bookingRepository, UserRepository $userRepository, HousingRepository $housingRepository)
    {
        $this->bookingRepository = $bookingRepository;
        $this->userRepository = $userRepository;
        $this->housingRepository = $housingRepository;
    }

    /**
     * @Route("/api/booking/{userId}/{housingId}/{dateStart}/{dateEnd}", name="create_booking")
     */
    public function createBooking($userId, $dateStart, $dateEnd, $housingId)
    {
        header("Access-Control-Allow-Origin: *");
        $manager = $this->getDoctrine()->getManager();

        try {
            $booking = new Booking();
            $booking->setCreatedAt(new \DateTime())
                    ->setDateStartAt(strtotime($dateStart))
                    ->setDateEndAt(strtotime($dateEnd))
                    ->setNumberTraveling(1)
                    ->setUser($this->userRepository->find($userId))
                    ->setHousing($this->housingRepository->find($housingId));

            $manager->persist($booking);
            $manager->flush();

            return $this->json(['message' => 'La réservation a bien été effectuée', 'code' => 201]);

        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage(), 'code' => 500]);
        }
    }

    
}
