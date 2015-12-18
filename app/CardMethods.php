<?php //namespace CantinaPoker\Casino;

class CardMethods
{
    /**
     * Checks an array of cards for the same suite
     *
     * @param array $cards
     * @param $bool
     * @param integer $numberOfSuits
     * @return bool
     */
    public static function sameSuit(array $cards, $bool, $numberOfSuits = 5)
    {
        $suits = array();
        foreach($cards as $card) {
            if(!array_key_exists($card->getSuit(), $suits)) {
                $suits[$card->getSuit()] = 1;
            } else {
                $suits[$card->getSuit()] += 1;
            }
        }
        if(max($suits) == $numberOfSuits) {
            return true;
        }
        return false;
    }
    public static function sameRank(array $cards, $numberOfRanks = 5)
    {
        $ranks = array();
        foreach($cards as $card) {
            if(!array_key_exists($card->getRank(), $ranks)) {
                $ranks[$card->getRank()] = 1;
            } else {
                $ranks[$card->getRank()] += 1;
            }
        }
        if(max($ranks) == $numberOfRanks) {
            return true;
        }
        return false;
    }
    public static function sequential(array $cards)
    {
        $value_sort = array();
        foreach($cards as $card) {
            $value_sort[] = $card->getRank();
        }
        sort($value_sort);
        $min = min($value_sort);
        $max = max($value_sort);
        if($max - $min + 1 == 7) {
            return true;
        }
        return false;
    }
    public static function max_card(array $cards)
    {
        return max($cards);
    }
}
