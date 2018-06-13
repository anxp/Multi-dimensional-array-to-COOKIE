<?php

//функция dumpArray проходится по массиву, рекурсивно углубляясь во вложенные массивы, и выводит все значения массива со стоящими впереди них
//полными ключами. благодаря рекурсии уровень вложенности практически не ограничен.
//Пример вывода тестового массива:
/*
[0]->value1
[1]->value2
[2][0]->some1
[2][1]->some2
[2][2]->some3
[2][3]->some4
[2][4][0]->deepest1
[2][4][1]->deepest2
[2][4][2]->deepest3
[2][4][3]->deepest4
[2][4][4][0]->themostdeep1
[2][4][4][1]->themostdeep2
[2][4][4][2]->themostdeep3
[2][4][4][3]->themostdeep4
[2][4][5]->deepest6
[2][4][6]->deepest7
[3][0]->some1
[3][1]->some2
[3][2]->some3
[3][3]->some4
[3][4][0]->deepest1
[3][4][1]->deepest2
[3][4][2]->deepest3
[3][4][3]->deepest4
[3][4][4]->deepest5
[3][4][5]->deepest6
[3][4][6]->deepest7
[4]->value sublast1
[5]->value sublast2
[6][0]->thelast1
[6][1]->thelast2
[6][2]->thelast3
[6][3]->thelast4
[6][4]->thelast5
*/

//тестовый массив:
$testarray = array(
    0 => 'value1',
    1 => 'value2',
    2 => array(
        0 => 'some1',
        1 => 'some2',
        2 => 'some3',
        3 => 'some4',
        4 => array(
            0 => 'deepest1',
            1 => 'deepest2',
            2 => 'deepest3',
            3 => 'deepest4',
            4 => array(
                0 => 'themostdeep1',
                1 => 'themostdeep2',
                2 => 'themostdeep3',
                3 => 'themostdeep4',
            ),
            5 => 'deepest6',
            6 => 'deepest7',
        ),
    ),
    3 => array(
        0 => 'some1',
        1 => 'some2',
        2 => 'some3',
        3 => 'some4',
        4 => array(
            0 => 'deepest1',
            1 => 'deepest2',
            2 => 'deepest3',
            3 => 'deepest4',
            4 => 'deepest5',
            5 => 'deepest6',
            6 => 'deepest7',
        ),
    ),
    4 => 'value sublast1',
    5 => 'value sublast2',
    6 => array (
        0 => 'thelast1',
        1 => 'thelast2',
        2 => 'thelast3',
        3 => 'thelast4',
        4 => 'thelast5',
    ),
);

function dumpArray(array $array, array $keyPath=null) {
    if(count($array) > 0) {
        foreach ($array as $key => $value) {
            if(!is_array($value)) { //if element of parent array IS NOT array, we work with it like with end-value, and put it in file.
                if(!empty($keyPath)){
                    $pathString = implode("", $keyPath);
                } else $pathString = "";
                file_put_contents("dumparray.txt", $pathString."[$key]"."->".$value.PHP_EOL, FILE_APPEND);
            } else {
                //so, we've found a nested array, let's do something with it recursively...
                $keyPath[]="[$key]"; //add sub-array index to the end of path-array
                dumpArray($value, $keyPath); //indexes for end-elements this function will add during runtime
                $blackhHole = array_pop($keyPath); //delete sub-array index from the end of path-array. why? because we just dig out one level up
                //we don't need this index, so put it in $blackHole variable, which never used.
            }
        }
    }
}

//тест:
dumpArray($testarray);