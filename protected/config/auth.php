<?php 
return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    '1' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'guest', // унаследуемся от гостя
        ),
        'bizRule' => null,
        'data' => null
    ),
    '2' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Admin',
        'children' => array(
            '1',          // позволим модератору всё, что позволено пользователю
        ),
        'bizRule' => null,
        'data' => null
    ),
    '3' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'SuperAdministrator',
        'children' => array(
            '2',         // позволим админу всё, что позволено модератору
        ),
        'bizRule' => null,
        'data' => null
    ),
);
?>