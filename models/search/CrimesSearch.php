<?php
namespace app\models\search;

use app\models\Crimes;
use app\models\Suspects;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CrimesSearch extends Crimes
{
    //
    public $quantity;
    public $names;
    public $coordinates;
    public $orders;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['id', 'code_id', 'crime_number','quantity'], 'integer'],
           [['crime_name', 'crime_date', 'crime_location', 'lat', 'long','names','coordinates', 'orders'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = Crimes::find()->groupBy(self::tableName() . '.id');
        $query->joinWith('suspects');

        $dataProvider = new ActiveDataProvider([
           'query' => $query,
           'pagination' => ['pageSize' => 20],

        ]);

        $this->load($params);

        $query->andFilterWhere([
           self::tableName() . '.id' => $this->id,
           self::tableName() . '.code_id' => $this->code_id,
           self::tableName() . '.crime_number' => $this->crime_number,
           self::tableName() . '.crime_date' => $this->crime_date,
           Suspects::tableName() . '.quantity' => $this->quantity,
        ]);

        $query->andFilterWhere(['like', 'crime_name', $this->crime_name])
           ->andFilterWhere(['like', 'crime_location', $this->crime_location])
           ->orFilterWhere(['like', 'lat', $this->coordinates])
           ->orFilterWhere(['like', 'long', $this->coordinates])
           ->andFilterWhere(['like', Suspects::tableName() . '.name', $this->names]);

        return $dataProvider;
    }
}