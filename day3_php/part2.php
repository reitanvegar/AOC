<?php

function get_lines () {

    $stdin = fopen('php://stdin', 'r');
    $lines = [];

    /* Get line from stdin*/
    while (($line = fgets($stdin)) !== false) {
        $lines[] = $line;
    }

    return $lines;
}

/* Find location of adjacent digits */
function find_adjacent_digits(array $lines, int $line_nr, int $pos, int $len=1) : array {

    $line = $lines[$line_nr];

    /* If not start of line */
    if ($pos != 0){
        $pos -= 1;
        $len += 1;
    }
    
    /* If not end of line */
    if($pos + $len < strlen($line)){
        $len += 1;
    }

    $adjacent_nums=[];
    $matched_nums = [];
    if(preg_match_all("/\d{1,}/", substr($line, $pos, $len), $matched_nums, PREG_OFFSET_CAPTURE)){
        foreach($matched_nums[0] as $num){
            $digit_offset = $num[1];
            $adjacent_nums[] = [
                "line_nr" => $line_nr,
                "char_off" => $digit_offset + $pos
            ];
        }
    }
    return $adjacent_nums;
}

/* Find number which has a digit at character offset */
function find_number_at_char_offset(array $lines, int $line_nr, int $char_offset){
    $number_match=[];
    preg_match("/^.{".($char_offset)."}\d+/", $lines[$line_nr], $number_match);
    preg_match("/\d+$/", strval($number_match[0]), $number_match);
    return $number_match[0];
}


$sum = 0;
$lines = get_lines();

for($i=0; $i < count($lines); $i++){
    $gears = [];
    preg_match_all("/\*/", $lines[$i], $gears, PREG_OFFSET_CAPTURE);
    foreach ($gears[0] as $gear){
        $gear_pos=$gear[1];
        
        $count_adjacent = 0;
        $numbers = [];

        /* Check previous line */
        if($i != 0){
            $numbers = array_merge($numbers, find_adjacent_digits($lines, $i-1, $gear_pos));
        }

        /* Check line gear is in */
        $numbers = array_merge($numbers, find_adjacent_digits($lines, $i, $gear_pos));


        /* Check next line */
        if($i != count($lines)-1){
            $numbers = array_merge($numbers, find_adjacent_digits($lines, $i+1, $gear_pos));
        }

        print_r($numbers);
        /* Only care if exactly two matches */
        if(count($numbers) == 2){
            $first_num = find_number_at_char_offset($lines, $numbers[0]['line_nr'], $numbers[0]['char_off']);
            $second_num = find_number_at_char_offset($lines, $numbers[1]['line_nr'], $numbers[1]['char_off']);
            $sum += $first_num * $second_num;
        }
    }
}

echo "$sum\n"
?>
