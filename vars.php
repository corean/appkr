<?php

$vars = ["", 0, 0.0, "0", NULL, FALSE, []];
foreach ($vars as $var) {
    echo $var = isset($var) ? ' - true <br>' : ' - false <br>';
}
echo '----- <br>';

foreach ($vars as $var) {
    echo ($var) ? $var . ' - true <br>' : $var . ' - false <br>';
}
echo '----- <br>';

foreach ($vars as $var) {
    echo (isset($var) and $var) ? $var . ' - true <br>' : $var . ' - false <br>';
}
echo '----- <br>';

foreach ($vars as $var) {
    echo !empty($var) ? $var . ' - true <br>' : $var . ' - false <br>';
}
echo '----- <br>';