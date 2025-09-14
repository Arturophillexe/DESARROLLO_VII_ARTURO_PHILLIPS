<?php
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";
}
echo "<br>";

$num = 1;
while ($num <= 20) {
    if ($num % 2 !== 0) {
        echo $num . "<br>";
    }
    $num++;
}
echo "<br>";

$counter = 10;
do {
    if ($counter !== 5) {
        echo $counter . "<br>";
    }
    $counter--;
} while ($counter >= 1);
?>
