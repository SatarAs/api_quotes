<?php

namespace App\Controller;

use App\Entity\Quotes;
use App\Repository\QuotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class APIController extends AbstractController
{

    /**
     * @Route("/api", name="api_index", methods={"GET"})
     * @return Response
     */
    public function index() : Response
    {
        return new Response('<html><body>Bienvenue sur l\'API Quotes</body></html>');
    }

    /**
     * @Route("/api/quotes/list", name="api_list", methods={"GET"})
     * @param QuotesRepository $quotesRepository
     * @return Response
     */
    public function list(QuotesRepository $quotesRepository)
    {
        $quotes = $quotesRepository->apiFindAll();
        $quote = $quotesRepository->findAllArray();
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($quotes, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

//        Test Affichage de la liste
//        return $this->render('api/index.html.twig', [
//            'quotes' => $quote
//        ]);
    }

    /**
     * @Route("/api/quote/show/{id}", name="api_quote", methods={"GET"})
     * @param Quotes $quote
     * @return Response
     */
    public function getQuote(Quotes $quote)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($quote, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/api/quote/add", name="api_add", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function addQuote(Request $request) : Response
    {
        if($request->isXmlHttpRequest()) {
            $quote = new Quotes();

            $data = json_decode($request->getContent());

            $quote->setStrQuote($data->strQuote);
            $quote->setRating($data->rating);
            $quote->setDate($data->date);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            return new Response('ok', 201);
        }
        return new Response('Failed', 404);
    }

    /**
     * @Route("/api/quote/edit/{id}", name="api_edit", methods={"PUT"})
     * @param Quotes|null $quote
     * @param Request $request
     * @return Response
     */
    public function editQuote(?Quotes $quote, Request $request) : Response
    {
        if($request->isXmlHttpRequest()) {
            $data = json_decode($request->getContent());
            $code = 200;

            if(!$quote){
                $quote = new Quotes();
                $code = 201;
            }

            $quote->setStrQuote($data->strQuote);
            $quote->setRating($data->rating);
            $quote->setDate($data->date);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quote);
            $entityManager->flush();

            return new Response('ok', $code);
        }
        return new Response('Failed', 404);
    }

    /**
     * @Route("/api/quote/remove/{id}", name="api_remove", methods={"DELETE"})
     * @param Quotes $quote
     * @return Response
     */
    public function removeQuote(Quotes $quote) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($quote);
        $entityManager->flush();

        return new Response('ok', 200);
    }

}
