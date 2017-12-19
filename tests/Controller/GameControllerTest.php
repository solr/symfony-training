<?php
/**
 * Created by PhpStorm.
 * User: solr
 * Date: 19.12.2017
 * Time: 16:58
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GameControllerTest
 * @package App\Tests\Controller
 * @covers \App\Controller\GameController
 */
class GameControllerTest extends WebTestCase
{
    public function testPageLoads(){
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testPlayCorrectWord(){
        $client = static::createClient();
        $client->followRedirects(true);
        $crawler = $client->request('GET', '/');
        $form = $crawler->selectButton('Let me guess...')->form();
        $crawler = $client->submit($form, ['word' => 'airplane']);
        $this->assertContains('winner', $crawler->filter('h2')->text());
    }
}