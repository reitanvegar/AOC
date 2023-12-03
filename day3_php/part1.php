<?php

/* Read from standard in */
$stdin = fopen('php://stdin', 'r');

$lines = [];

$sum = 0;

/* Get line from stdin*/
while (($line = fgets($stdin)) !== false) {
    $lines[] = $line;
}

function check_if_symbol_at_position(string $line, int $pos_low, int $len) : bool {
    if ($pos_low != 0){
        $pos_low -= 1;
        $len += 1;
    }

    if($pos_low + $len < strlen($line)){
        $len += 1;
    }

    echo "substr: " . substr($line, $pos_low, $len) . "\n";
    return preg_match("/[^.\d\n]/", substr($line, $pos_low, $len));
}


for($i=0; $i < count($lines); $i++){
    $matches = [];
    preg_match_all("/\d{1,}/", $lines[$i], $matches, PREG_OFFSET_CAPTURE);
    foreach ($matches[0] as $match){
         $do_sum = false;
         $number=$match[0];
         $pos=$match[1];
         $len=strlen(strval($number));
      
         /*check that previous line and next line does not contain symbol at pos-1 to pos+len+1 */
         if($i != 0){
            if(check_if_symbol_at_position($lines[$i-1], $pos, $len)){
            $do_sum = true;
        }
         }

         if(check_if_symbol_at_position($lines[$i], $pos, $len)){
            $do_sum = true;
         }   


         if($i != count($lines)-1){
            if(check_if_symbol_at_position($lines[$i+1], $pos, $len)){
            $do_sum = true;
            }
         }
         if($do_sum) $sum += $number;
         
         if($do_sum){
           echo "YES";
         }else{
           echo "NO";
         }

         echo "\n\n";
    }

}

echo "$sum\n"
?>
