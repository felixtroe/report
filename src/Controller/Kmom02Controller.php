<?php

namespace App\Controller; // gör så att symfony hittar filen samt PHP autoloader

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCards;
use App\Card\CardHand;

class Kmom02Controller extends AbstractController
{
    #[Route("/session", name: "session_landing", methods: ['GET'])]
    public function session(SessionInterface $session): Response
    {
        if ($session ->get("deck_of_cards")) {
            $deck = $session ->get("deck_of_cards");
            $hand = $session ->get("drawn_cards");
            $deckArray = $deck -> getString();
            $handArray = $hand -> getString();
            $numberOfCards = $hand -> getNumberCard();
            $data = [
              "deckOfCards" => $deckArray,
              "drawnCard" => $handArray,
              "CardsInDeck" => $session->get("cards_in_deck"),
              "numberOfCards" => $numberOfCards
        ];
            return $this->render('cardgame/landingSession.html.twig', $data);
        }
        $this->addFlash(
            'notice',
            'Session is empty'
        );
        return $this->render('home.html.twig');
    }

    #[Route("/session/delete", name: "delete", methods: ['POST'])]
    public function delete(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash(
            'notice',
            'Deck is cleared'
        );

        return $this->redirectToRoute('card');
    }


    #[Route("/card", name: "card")]
    public function card(): Response
    {

        return $this->render('cardgame/cardLanding.html.twig');
    }

    #[Route("/card/deck", name: "show_deck", methods: ['GET'])]
    public function showDeck(SessionInterface $session): Response
    {
        $deck = $session ->get("deck_of_cards");
        $deckArray = $deck -> getString();

        $data = [
         "deckOfCards" => $deckArray,
      ];

        return $this->render('cardgame/deck/cardDeck.html.twig', $data);
    }


    #[Route("/card/deck", name: "card_deck_post", methods: ['POST'])]
    public function cardDeckPost(SessionInterface $session): Response
    {
        if (empty($session->get("deck_of_cards"))) {
            $deck = new DeckOfCards();
            $hand = new CardHand();
            $session->set("deck_of_cards", $deck);
            $session->set("drawn_cards", $hand);
        }
        return $this->redirectToRoute('show_deck');
    }



    #[Route("/card/deck/shuffle", name: "shuffle", methods: ['POST'])]
    public function shuffle(SessionInterface $session): Response
    {
        $deck = $session->get("deck_of_cards");

        $check = $this-> showMes($deck, 0);

        if (!$check) {
            return $this->redirectToRoute('card');
        }


        $deck->shuffleCards();
        $session->set("deck_of_cards", $deck);
        return $this->redirectToRoute('show_deck');
    }


    #[Route("/card/deck/draw ", name: "show_drawn", methods: ['GET'])]
    public function showDraw(SessionInterface $session): Response
    {
        $hand = $session ->get("drawn_cards");

        $handArray = $hand -> getString();
        $numberOfCards = $hand -> getNumberCard();

        $data = [
         "drawnCards" => $handArray,
         "numOfCards" => $numberOfCards,
         "cardsInDeck" => $session -> get("cards_in_deck")
    ];

        return $this->render('cardgame/deck/cardHand.html.twig', $data);
    }


    #[Route("/card/deck/draw", name: "draw", methods: ['POST'])]
    public function draw(SessionInterface $session): Response
    {
        $deck = $session->get("deck_of_cards");
        $hand = $session->get("drawn_cards");

        $check = $this-> showMes($deck, 1);

        if (!$check) {
            return $this->redirectToRoute('card');
        }

        $card = $deck->draw();
        $numLeftDeck = $deck-> getNumberCard();
        $hand ->add($card);

        $session->set("drawn_cards", $hand);
        $session->set("deck_of_cards", $deck);
        $session->set("cards_in_deck", $numLeftDeck);

        return $this->redirectToRoute('show_drawn');

    }



    #[Route("/card/deck/draw/{num<\d+>}", name: "num_draw_cards", methods: ['POST'])]
    public function drawNum(SessionInterface $session, $num): Response
    {

        if ($num > 52) {
            throw new \Exception("Kan inte välja mer än 52 kort!");
        }

        $hand = $session->get("drawn_cards");
        $deck = $session->get("deck_of_cards");

        $check = $this-> showMes($deck, $num);

        if ($check == false) {
            return $this->redirectToRoute('card');
        }

        for ($i = 0; $i < $num; $i++) {
            $card = $deck->draw();
            $hand ->add($card);
        }

        $numLeftDeck = $deck-> getNumberCard();

        $session->set("drawn_card", $hand);
        $session->set("cards_in_deck", $numLeftDeck);
        $session->set("deck_of_cards", $deck);

        return $this->redirectToRoute('show_drawn');
    }



    private function showMes($deck, $num): bool
    {

        if (!$deck || $deck -> getNumberCard() - $num < 0) {
            $this->addFlash(
                'notice',
                'To few cards in deck'
            );
            return false;
        }

        return true;
    }


}
