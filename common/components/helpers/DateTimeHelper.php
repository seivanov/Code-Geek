<?php

namespace common\components\helpers;

class DateTimeHelper
{

    public static function getDisplayDateTime($date)
    {

        return date('d', $date) . ' ' . self::month(date('m', $date)) . ' ' . date('Y', $date);

    }

    private function month($month_num) {

        $month = array(
            "01" => "января",
            "02" => "февраля",
            "03" => "марта",
            "04" => "апреля",
            "05" => "мая",
            "06" => "июня",
            "07" => "июля",
            "08" => "августа",
            "09" => "сентября",
            "10" => "октября",
            "11" => "ноября",
            "12" => "декабря"
        );

        return $month[$month_num];

    }

}

?>