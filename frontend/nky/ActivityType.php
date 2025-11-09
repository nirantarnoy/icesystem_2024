<?php

namespace backend\helpers;

class ActivityType
{
    private static $data = [
        '1' => 'รับเข้าผลิต',
        '2' => 'เบิกขึ้นรถ',
        '3' => 'เบิกเติม',
        '4' => 'คืนขายหน่วยรถ',
        '5' => 'เบิกขาย POS',
        '6' => 'ปรับยอด',
        '7' => 'โอนระหว่างสาขา'
    ];

    private static $dataobj = [
        ['id' => '1', 'name' => 'รับเข้าผลิต'], // 15
        ['id' => '2', 'name' => 'เบิกขึ้นรถ'], // 6
        ['id' => '3', 'name' => 'เบิกเติม'], // 18
        ['id' => '4', 'name' => 'คืนขายหน่วยรถ'], //7
        ['id' => '5', 'name' => 'เบิกขาย POS'], //4
        ['id' => '6', 'name' => 'ปรับยอด'], //11
        ['id' => '7', 'name' => 'โอนระหว่างสาขา'] // 19
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
