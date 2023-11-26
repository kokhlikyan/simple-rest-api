<?php
function random_number($digits): int
{
    return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
}
