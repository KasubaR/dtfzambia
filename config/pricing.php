<?php

return [
    /*
     * Bundle pricing tiers (number of courses => price in Kwacha).
     * For counts beyond the highest tier, each additional course costs `per_additional`.
     */
    'tiers' => [
        1 => 1750,
        2 => 3000,
        3 => 4750,
    ],

    'per_additional' => 1750,
];
