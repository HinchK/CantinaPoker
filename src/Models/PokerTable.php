<?php namespace CantinaPoker\Models;


class PokerTable
{
    protected $players;

    public function __construct($numberOfPlayers)
    {
        $this->players = intval($numberOfPlayers);
    }

    public function createTable()
    {
        $playing = array();

        for ($i = 0; $i < $this->players; $i++) {
            $playerNumber = $i + 1;
            $playerName = "Player " . $playerNumber;
            $playing[$i] = new Player($playerName);
        }

        return $playing;
    }
}
