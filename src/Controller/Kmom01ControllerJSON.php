<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Kmom01ControllerJSON
{

  #[Route("/api")]
  public function jsonAPI(): Response
  {
      $number = random_int(0, 100);

      $data = [
          'lucky-number' => $number,
          'lucky-message' => 'Hi there!',
      ];

      return new JsonResponse($data);
  }

  #[Route("/api/quote")]
  public function quote(): Response
  {
      $number = random_int(0, 2);

      $quotes= ["You may learn much more from a game you lose than from a game you win",
      "A book cannot by itself teach how to play. It can only serve as a guide, and the rest must be learned by experience.",
      "Sometimes a Pawn is enough to change the whole game and those who ignore the importance of it, are liable to lose their Queen"];

      $data = [
          'quotes' => $quotes[$number],
          'time' => date('H:i:s'),
          'date' => date('Y-m-d')

      ];

      return new JsonResponse($data);
  }

}

