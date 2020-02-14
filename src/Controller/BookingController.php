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
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;

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

    /**
     * @var $serializer
     */
    private $serializer;

    public function __construct(BookingRepository $bookingRepository, UserRepository $userRepository, HousingRepository $housingRepository, SerializerInterface $serializer)
    {
        $this->bookingRepository = $bookingRepository;
        $this->userRepository = $userRepository;
        $this->housingRepository = $housingRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/bookings/read/{userId}/", name="read_booking")
     */
    public function bookings($userId)
    {
        header("Access-Control-Allow-Origin: *");

        try {
            $bookings = $this->bookingRepository->findBy(['user' => $this->userRepository->find($userId)]);
            $bookingsTransform = [];

            foreach($bookings as $booking) {
                $bookingsTransform[] = [
                    'id' => $booking->getId(),
                    'dateStart' => $booking->getDateStartAt(),
                    'dateEnd' => $booking->getDateEndAt(),
                    'housing' => [
                        'title' => $booking->getHousing()->getTitle(),
                        'adresse' => $booking->getHousing()->getAddress(),
                        'price' => $booking->getNbDays() * $booking->getHousing()->getPrice(),
                        'picture' => $booking->getHousing()->getPicture()
                    ]
                ];
            }

            return $this->json($bookingsTransform);

        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage(), 'code' => 500]);
        }
    }

    /**
     * @Route("/api/booking/create/{userId}/{housingId}/{dateStart}/{dateEnd}", name="create_booking")
     */
    public function createBooking($userId, $dateStart, $dateEnd, $housingId)
    {
        header("Access-Control-Allow-Origin: *");
        $manager = $this->getDoctrine()->getManager();

        try {
            $booking = new Booking();
            $booking->setCreatedAt(new \DateTime())
                    ->setDateStartAt(new \DateTime($dateStart))
                    ->setDateEndAt(new \DateTime($dateEnd))
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
