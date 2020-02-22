<?php


namespace app\components;


class Provider
{
    public static function getPersonAge($dateOfBirth)
    {
        //format- 1984-07-31
        $dateOfBirth = explode("-", $dateOfBirth);
        $age = (date("md", date("U", mktime(0, 0, 0, $dateOfBirth[1], $dateOfBirth[2], $dateOfBirth[0]))) > date("md")
            ? ((date("Y") - $dateOfBirth[0]) - 1)
            : (date("Y") - $dateOfBirth[0]));
        return $age;
    }

    public static function getCreditScore($score)
    {
        $result = 0;
        switch($score){
            case 'good':
                $result = 700;
                break;
            case 'bad':
                $result = 300;
                break;
        }
        return $result;
    }
}