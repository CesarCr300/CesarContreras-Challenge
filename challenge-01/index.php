<?php

function findPoint($strArr)
{
    $BAD_RESULT = 'false';

    if ($strArr[0] == '' || $strArr[1] == '') {
        return $BAD_RESULT;
    }

    $firstArray = array_map('intval', explode(',', string: $strArr[0]));
    $secondArray = array_map('intval', explode(',', $strArr[1]));

    $secondArraySize = count($secondArray);
    $firstArraySize = count($firstArray);
    if ($secondArraySize == 0 || $firstArraySize == 0)
        return $BAD_RESULT;

    $secondArrayIndex = 0;

    $result = [];

    for ($firstArrayIndex = 0; $firstArrayIndex < $firstArraySize; $firstArrayIndex++) {
        $numberBase = $firstArray[$firstArrayIndex];
        while ($secondArrayIndex < $secondArraySize) {
            $secondArrayNumber = $secondArray[$secondArrayIndex];
            if ($numberBase < $secondArrayNumber) {
                break;
            }
            if ($numberBase == $secondArrayNumber) {
                array_push($result, $numberBase);
                $secondArrayIndex++;
                break;
            }

            $secondArrayIndex++;
        }
    }
    if (count($result) == 0)
        return $BAD_RESULT;
    return implode(',', $result);
}

// keep this function call here
echo findPoint(['1, 3, 4, 7, 13', '1, 2, 4, 13, 15']);

echo findPoint(['1, 3, 9, 10, 17, 18', '1, 4, 9, 10']);