<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "suspects".
 *
 * @property int $id
 * @property int $crime_id
 * @property int $code_link_id
 * @property string|null $quantity
 * @property string|null $name
 */
class Suspects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suspects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['crime_id', 'code_link_id'], 'required'],
            [['crime_id', 'code_link_id'], 'integer'],
            [['quantity'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 120],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crime_id' => 'Crime ID',
            'code_link_id' => 'Code Link ID',
            'quantity' => 'Quantity',
            'name' => 'Name',
        ];
    }
}
