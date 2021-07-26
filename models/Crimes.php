<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "crimes".
 *
 * @property int $id
 * @property int|null $code_id
 * @property string|null $crime_name
 * @property int|null $crime_number
 * @property string|null $crime_date
 * @property string|null $crime_location
 * @property string|null $lat
 * @property string|null $long
 * @property array|null $orders
 */
class Crimes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crimes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code_id', 'crime_number'], 'integer'],
            [['crime_date'], 'safe'],
            [['crime_name', 'crime_location', 'lat', 'long'], 'string', 'max' => 255],
            [['code_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_id' => 'Code ID',
            'crime_name' => 'Crime Name',
            'crime_number' => 'Crime Number',
            'crime_date' => 'Crime Date',
            'crime_location' => 'Crime Location',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    public function getSuspects(){
        return $this->hasMany(Suspects::class, ['code_link_id' => 'code_id']);
    }
}
