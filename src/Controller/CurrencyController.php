<?php

namespace App\Controller;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    #[Route('/currency', name: 'currency')]
    public function index(): Response
    {
        return $this->render('currency/index.html.twig');
    }

    /**
     * @Route("/currency/generateButton", name="SaveCurrency")
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

        $em = $this->getDoctrine()->getManager();

        foreach ($decode[0]->rates as $currency) {
            if ($existingCurrency = $this->currencyRepository->findOneBy(['currency_code' => $currency->code])) {
                $existingCurrency->setExchangeRate($currency->mid);
            } else {
            $curr = new Currency();
            $curr->setName($currency->currency);
            $curr->setCurrencyCode($currency->code);
            $curr->setExchangeRate($currency->mid);

            $em->persist($curr);
            $em->flush();
            }
        }
    
        return $this->render('currency/currency_table.html.twig',[
            'items' => $this->currencyRepository->findAll() ?? null
        ]);


    }
}
