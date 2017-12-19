<?php
/**
 * Created by PhpStorm.
 * User: solr
 * Date: 19.12.2017
 * Time: 16:05
 */

namespace App\Tests\Game;

use App\Game\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testPlayCorrectWord() {
        $game = new Game('php');
        $this->assertTrue($game->tryWord('php'));
        $this->assertTrue($game->isWon());
    }

    public function testPlayWrongWord() {
        $game = new Game('php');
        $game->tryWord('lala');
        $this->assertTrue($game->isHanged());
    }

    public function testPlayCorrectLetter() {
        $game = new Game('word');
        $this->assertTrue($game->tryLetter('o'));
    }
    public function testPlayCorrectLetterTwice() {
        $game = new Game('word');
        $game->tryLetter('o');
        $this->assertFalse($game->tryLetter('o'));
    }
    public function testPlayIncorrectLetter() {
        $game = new Game('word');
        $this->assertFalse($game->tryLetter('a'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPlayNonLetter() {
        $game = new Game('php');
        $game->tryLetter('3');
    }


}