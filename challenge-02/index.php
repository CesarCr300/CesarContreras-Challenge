<?php

class CharacterObject
{
    private $character;
    private $needsToHave;
    private $positions;

    public function __construct($character, $needsToHave = 1)
    {
        $this->character = $character;
        $this->needsToHave = $needsToHave;
        $this->positions = [];
    }

    public function increaseNeedsToHave()
    {
        $this->needsToHave++;
    }

    public function addPositionFounded($position)
    {
        array_push($this->positions, $position);
    }

    public function removePosition($position)
    {
        $quantityOfCharactersAfterRemove = count($this->positions) - 1;
        //Only allow removal if it does not leave less than the required number of characters
        if ($quantityOfCharactersAfterRemove < $this->needsToHave) {
            return false;
        }
        $index = array_search($position, $this->positions);
        if ($index !== false) {
            unset($this->positions[$index]);
            return true;
        }
    }

}

function getMatchedCharacterPositions
(
    $arr,
    $charactersToFind
) {
    $positions = [];
    for ($index = 0; $index < count($arr); $index++) {
        $characterToFind = $arr[$index];
        if (array_key_exists($characterToFind, $charactersToFind)) {
            $characterObject = $charactersToFind[$characterToFind];
            $characterObject->addPositionFounded($index);

            $positions[$index] = $characterObject;
        }
    }
    return $positions;
}

/**
 *  
 * @param array<number, CharacterObject>$positions
 * @return number
 */
function shrinkPositionsArray($positions): int
{
    $breakpoint = 0;
    foreach ($positions as $position => $characterObject) {
        $success = $characterObject->removePosition($position);
        if (!$success) {
            $breakpoint = $position;
            break;
        }
        unset($positions[$position]);
    }
    return $breakpoint;
}

function getCharactersToFind($charactersArray)
{
    $charactersToFind = [];
    for ($index = 0; $index < strlen($charactersArray); $index++) {
        $characterToFind = $charactersArray[$index];
        if (array_key_exists($characterToFind, $charactersToFind)) {
            $charactersToFind[$characterToFind]->increaseNeedsToHave();
        } else {
            $charactersToFind[$characterToFind] = new CharacterObject($characterToFind);
        }
    }
    return $charactersToFind;
}

function noIterate($strArr)
{
    // code goes here
    /** @var array<string, CharacterObject> */
    $charactersToFind = getCharactersToFind($strArr[1]);
    /** @var array<number, CharacterObject> */
    $positions = getMatchedCharacterPositions(
        str_split($strArr[0]),
        $charactersToFind
    );

    //Shrink from the left
    $start_index = shrinkPositionsArray($positions);

    //Shrink from the right
    $end_index = shrinkPositionsArray(array_reverse($positions, true));

    return implode('', array_slice(str_split($strArr[0]), $start_index, $end_index - $start_index + 1));
}

// keep this function call here
echo noIterate(["aaffhkksemckelloe", "fhea"]);
