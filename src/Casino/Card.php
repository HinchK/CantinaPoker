<?php namespace CantinaPoker\Casino;
/**
 * Class Card
 * @package CantinaPoker\Casino
 */

class Card
{
    protected $value;
    protected $suit;

    public function __construct($value, $suit)
    {
        $this->dealCardValue($value);
        $this->dealCardSuit($suit);
    }

    /**
     * Setting Card Value
     * @param $value
     */
    public function dealCardValue($value)
    {
        $this->value = $value;
    }

    /**
     * Setting Suit
     * @param $suit
     */
    public function dealCardSuit($suit)
    {
        $this->suit = $suit;
    }

    public function viewCardValue()
    {
        return $this->value;
    }

    public function viewCardSuit()
    {
        return $this->suit;
    }

    public function flipCard()
    {
        echo "[ " . $this->value . " of " . $this->suit . " ]";
    }

}
