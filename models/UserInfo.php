<?php


namespace app\models;


class UserInfo extends \yii\base\BaseObject
{
    public $id;
    public $firstName;
    public $lastName;
    public $dateOfBirth;
    public $Salary;
    public $creditScore;

    private static $userInfo = [
        '99' => [
            'id' => '99',
            "firstName" => "Vasya",
            "lastName" => "Pupkin",
            "dateOfBirth" => "1984-07-31",
            "Salary"    	=> "1000",
            "creditScore" => "good"
        ],
    ];

    public static function getUserInfoById($id)
    {
        return isset(self::$userInfo[$id]) ? new static(self::$userInfo[$id]) : null;
    }
}