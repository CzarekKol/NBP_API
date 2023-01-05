<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    #[Route('/currency', name: 'app_currency')]
    public function index(): Response
    {
        return $this->render('currency/index.html.twig');
    }

    /**
     * @Route("/currency/generateButton", name="name")
     */
    public function getAndSaveCurrencyAction(): Response
    {
        $ci = curl_init();
        $url = "http://api.nbp.pl/api/exchangerates/tables/A/";
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ci);

        if ($error = curl_errno($ci)) {
            $error;
        } else {
            $decode = json_decode($response);
        }

        return $this->render('currency/currency_table.html.twig',[
            'items' => $decode ?? null,
            'error' => $error ?? null
        ]);


    }
}
