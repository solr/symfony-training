<?php

namespace App\Controller;

use App\Game\GameRunner;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GameController
 * @package App\Controller
 * @Security("has_role('ROLE_PLAYER')")
 */
class GameController extends Controller
{
    /**
     * @var GameRunner
     */
    private $runner;

    /**
     * @param GameRunner $runner
     */
    public function __construct(GameRunner $runner)
    {
        $this->runner = $runner;
    }

    /**
     * @Route(path="/", name="app_game")
     */
   public function indexAction()
   {
       $game = $this->runner->loadGame();
       if ($game->isWon()) {
           return $this->redirectToRoute('app_game_won');
       }
       if ($game->isHanged()) {
           return $this->redirectToRoute('app_game_hanged');
       }
       return $this->render('game.html.twig', ['game' => $game]);
   }

    /**
     * @param $letter string
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Method("GET")
     * @Route(  path="/letter/{letter}",
     *          name="app_game_letter",
     *          requirements={"letter"="^[a-z]$"})
     */
   public function playLetterAction($letter)
   {
       $this->runner->playLetter($letter);
       return $this->redirectToRoute('app_game');
   }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Method("POST")
     * @Route(path="/word", name="app_game_word")
     */
   public function playWordAction(Request $request)
   {
       $word = $request->request->get('word');
       $this->runner->playWord($word);
       return $this->redirectToRoute('app_game');
   }

    /**
     * @Route(path="/reset", name="app_game_reset")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
   public function playResetAction() {
       $this->runner->resetGame();
       return $this->redirectToRoute('app_game');
   }

    /**
     * @Route(path="/won", name="app_game_won")
     */
   public function playGameWonAction() {
       $game = $this->runner->loadGame();
       if ($game->isWon()) {
           $this->runner->resetGame();
           return $this->render('won.html.twig', ['game' => $game]);
       }
       return $this->render('nicetry.html.twig');
   }

    /**
     * @Route(path="/hanged", name="app_game_hanged")
     */
    public function playGameHangedAction() {
        $game = $this->runner->loadGame();
        if ($game->isHanged()) {
            $this->runner->resetGame();
            return $this->render('hanged.html.twig', ['game' => $game]);
        }
        return $this->render('why.html.twig');
    }
}