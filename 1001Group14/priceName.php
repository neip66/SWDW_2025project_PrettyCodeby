<?php
// Single source of truth for item data — included by all product pages.
// Avoid hardwiring item names / prices into individual pages.
//
// Key = itemN (matches the itemN column in the purchase DB table
// and the file name of the corresponding image).

$ITEMS = [
    // clothes
    'ancientShirt' => ['category' => 'clothes', 'name' => 'ancient shirt', 'price' => 100],
    'cap'          => ['category' => 'clothes', 'name' => 'cap',           'price' => 20],
    'cultureShirt' => ['category' => 'clothes', 'name' => 'culture shirt', 'price' => 50],
    'poloShirt'    => ['category' => 'clothes', 'name' => 'polo shirt',    'price' => 60],

    // necessities
    'calendar'     => ['category' => 'neces',   'name' => 'calendar',      'price' => 20],
    'fan'          => ['category' => 'neces',   'name' => 'fan',           'price' => 30],
    'mugs'         => ['category' => 'neces',   'name' => 'mugs',          'price' => 40],
    'umbrella'     => ['category' => 'neces',   'name' => 'umbrella',      'price' => 30],

    // ornaments
    'brooch'       => ['category' => 'orna',    'name' => 'brooch',        'price' => 40],
    'crystal'      => ['category' => 'orna',    'name' => 'crystal',       'price' => 40],
    'earRings'     => ['category' => 'orna',    'name' => 'ear rings',     'price' => 60],
    'necklace'     => ['category' => 'orna',    'name' => 'necklace',      'price' => 60],
];

function getItemsByCategory($category) {
    global $ITEMS;
    $out = [];
    foreach ($ITEMS as $itemN => $info) {
        if ($info['category'] === $category) {
            $out[$itemN] = $info;
        }
    }
    return $out;
}
?>
