<?php

namespace App\Controller;

use App\Service\HomepageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     *
     * @param HomepageService $homepageService
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homepage(HomepageService $homepageService)
    {
        $currencies = $homepageService->getLowestCurrencies();

        return $this->render(
            'homepage.html.twig',
            [
                'currencies' => $currencies,
            ]
        );
    }
}