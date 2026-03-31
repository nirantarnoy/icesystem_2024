<?php

namespace backend\helpers;

class Zone
{

    private static $data = [
        1 => 'ภาคกลาง',
        2 => 'ภาคเหนือ',
        3 => 'ภาคอีสาน',
        4 => 'ภาคใต้',
        5 => 'ภาคตะวันออก',
        6 => 'ภาคตะวันตก',
    ];

    private static $dataobj = [
        ['id'=>1,'name' => 'ภาคกลาง'],
        ['id'=>2,'name' => 'ภาคเหนือ'],
        ['id'=>3,'name' => 'ภาคอีสาน'],
        ['id'=>4,'name' => 'ภาคใต้'],
        ['id'=>5,'name' => 'ภาคตะวันออก'],
        ['id'=>6,'name' => 'ภาคตะวันตก'],
    ];
    public static function asArray()
    {
        return self::$data;
    }
    public static function asArrayObject()
    {
        return self::$dataobj;
    }
    public static function getTypeById($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }
    public static function getTypeByName($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }
}
