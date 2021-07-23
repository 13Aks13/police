<?php


namespace app\models;


use yii\base\Model;
use yii\db\ActiveRecord;

class Crimes extends ActiveRecord
{
    public $code_id;
    public $crime_name;
    public $crime_number;
    public $crime_date;
    public $crime_location;
    public $coordinates;
    public $lat;
    public $long;
    public $quantity;
    public $names;
}