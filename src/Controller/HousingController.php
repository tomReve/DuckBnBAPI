<?php

namespace App\Controller;

use App\Entity\Housing;
use App\Repository\HousingRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Response;

class HousingController extends AbstractFOSRestController
{
    /**
     * @var $housingRepository
     */
    private $housingRepository;

    public function __construct(HousingRepository $housingRepository)
    {
        $this->housingRepository = $housingRepository;
    }

    public function getHousingsAction()
    {
        header("Access-Control-Allow-Origin: *");
        return $this->housingRepository->findAll();
    }
}
