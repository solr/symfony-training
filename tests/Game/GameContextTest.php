<?php
/**
 * Created by PhpStorm.
 * User: solr
 * Date: 19.12.2017
 * Time: 16:33
 */

namespace App\Tests\Game;

use App\Game\Game;
use App\Game\GameContext;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class GameContextTest
 * @package App\Tests\Game
 * @covers \App\Controller\GameContext
 */
class GameContextTest extends TestCase
{
    public function testNewGame() {
        $session = $this->getMockForAbstractClass(SessionInterface::class);
        $context = new GameContext($session);
        $this->assertInstanceOf(Game::class, $context->newGame('php'));
    }

    public function testLoadExistingGame() {
        $session = $this->getMockForAbstractClass(SessionInterface::class);
        $session
            ->expects($this->once())
            ->method('get')
            ->with('hangman')
            ->willReturn([
                'word' => 'php',
                'attempts' => 2,
                'tried_letters' => ['p', 'r', 'j'],
                'found_letters' => ['p']
            ]);
        $context = new GameContext($session);
        $game = $context->loadGame();

        $this->assertInstanceOf(Game::class, $game);
        $this->assertTrue($game->isLetterFound('p'));
    }
}