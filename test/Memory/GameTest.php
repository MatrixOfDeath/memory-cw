<?php
//Créer un dossier tests pour y mettre tous les tests : Framework PHP pour les TU : PHP Unit
namespace Memory;

class GameTest extends \PhpUnit_Framework_TestCase
{

    protected $map;
    protected $game;

    protected function setUp()
    {
        $this->map = new Map(__DIR__.'/../../src/Public/images/game');

        $this->map->generate();
        $this->game = new Game($this->map);
    }

    public function testIsWon()
    {
        //methode d'assertion pour voir le retour d'une méthode (pour LA METHODE isWon quand on lui passe true : et qu'en cmd on lance php phpunit-4.x tests il lance un fail car il attend un false).
        $this->assertFalse($this->game->isWon());
    }

    public function testIsLost()
    {
        //methode d'assertion pour voir le retour d'une méthode (pour LA METHODE isWon quand on lui passe true : et qu'en cmd on lance php phpunit-4.x tests il lance un fail car il attend un false).
        $this->assertFalse($this->game->isLost());
    }

    public function testTryCombinationGood()
    {
        $this->game->tryCombination(array(0,0));
        $this->assertEquals(Game::MAX_ATTEMPTS, $this->game->getRemainingAttempts());
    }

    public function testTryCombinationFail()
    {
        $maplist = $this->map->getConfig();
        $failIndex = 0;

        while($maplist['map'][0]['src'] === $maplist['map'][$failIndex]['src']){
            $failIndex++;
        }

        $this->game->tryCombination(array(0,$failIndex));
        $this->assertNotEquals(Game::MAX_ATTEMPTS, $this->game->getRemainingAttempts());
    }

    public function testLostGame()
    {
        $maplist = $this->map->getConfig();
        $failIndex = 0;

        while($this->game->getRenaimingAttempts() > 0) {
            while ($maplist['map'][0]['src'] === $maplist['map'][$failIndex]['src']) {
                $failIndex++;
            }
            $this->game->tryCombination(array(0,$failIndex));
        }
        $this->assertEquals(0, $this->game->getRemainingAttemps());
        $this->game->tryCombination(array(0,$failIndex));

        $this->assertEquals(0, $this->game->getRemainingAttempts());
        $this->assertFalse($this->game->isLost());


        //$this->assertNotEquals(Game::MAX_ATTEMPTS, $this->game->getRemainingAttempts());
    }
}