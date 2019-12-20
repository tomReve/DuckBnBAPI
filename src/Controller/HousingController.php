<?php

namespace App\Controller;

use App\Repository\HousingRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;

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
        return $this->housingRepository->findAll();
    }

    /**
    public function getHousingsTasksAction(int $id)
    {

    }
    **/
}
