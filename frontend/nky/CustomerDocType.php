<?php

namespace backend\helpers;

class CustomerDocType
{
    private static $data = [
        '1' => 'เอกสารประกอบการขาย',
        '2' => 'เอกสารออกใบกำกับภาษี',
        '3' => 'เอกสารสัญญายืมถัง',
    ];

    private static $dataobj = [
        ['id' => '1', 'name' => 'เอกสารประกอบการขาย'], // 15
        ['id' => '2', 'name' => 'เอกสารออกใบกำกับภาษี'], // 6
        ['id' => '3', 'name' => 'เอกสารสัญญายืมถัง'], // 18
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
