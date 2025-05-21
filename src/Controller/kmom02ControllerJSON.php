<?php

namespace App\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCards;
use App\Card\CardHand;

class kmom02ControllerJSON
{
    #[Route("/api/deck", name: "api_deck", methods:['GET'])]
    public function deck(): Response
    {

        $cards = new DeckOfCards();
        $deck = $cards -> getDeckOfCards();
        foreach ($deck as $card) {

            $data[] = $card -> getString();
        }
        return new JsonResponse($data);
    }


    #[Route("/api/shuffle", name: "api_shuffle", methods:['POST'])]
    public function shuffle(SessionInterface $session): Response
    {

        $cards = new DeckOfCards();
        $hand = new CardHand();

        $cards -> shuffle();
        $deck = $cards -> getDeckOfCards();
        $data = $this-> jsonData($deck);

        $session->set("deck_api", $cards);
        $session->set("hand_api", $hand);
        return new JsonResponse($data);
    }

    #[Route("/api/deck/draw", name: "api_draw", methods:['POST'])]
    public function drawCard(SessionInterface $session): Response
    {
        $deck = $session -> get("deck_api");
        $hand = $session -> get("hand_api");

        $card = $deck -> draw();
        $hand -> add($card);

        $session->set("deck_api", $deck);
        $session->set("hand_api", $hand);
        $handOfCards = $hand -> getHand();
        $data = $this -> jsonData($handOfCards);
        $cardsInDeck = $deck -> getNumberCard();
        $data [] = "number of cards in deck : $cardsInDeck";

        return new JsonResponse($data);
    }



    #[Route("/api/deck/draw/{num<\d+>}", name: "api_draw_num", methods:['POST'])]
    public function drawNumCards(SessionInterface $session, $num): Response
    {
        $deck = $session -> get("deck_api");
        $hand = $session -> get("hand_api");

        for ($i = 0; $i < $num; $i++) {
            $card = $deck -> draw();
            $hand -> add($card);
        }

        $session->set("deck_api", $deck);
        $session->set("hand_api", $hand);
        $handOfCards = $hand -> getHand();
        $data = $this -> jsonData($handOfCards);
        $cardsInDeck = $deck -> getNumberCard();
        $data [] = "number of cards in deck : $cardsInDeck";

        return new JsonResponse($data);
    }


    private function jsonData(array $arrayObj): array
    {

        foreach ($arrayObj as $card) {
            $data[] = $card -> getString();
        }

        return $data;
    }
}
