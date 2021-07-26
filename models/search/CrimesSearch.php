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


        /*** code_id ***/
        if (isset($this->orders['code_id_asc']) && !isset($this->orders['code_id_desc']) && $this->orders['code_id_asc'] == 1)
            $query->orderBy(['code_id' => SORT_ASC]);

        if (isset($this->orders['code_id_desc']) && !isset($this->orders['code_id_asc']) && $this->orders['code_id_desc'] == 1)
            $query->orderBy(['code_id' => SORT_DESC]);

        /*** crime_name ***/
        if (isset($this->orders['crime_name_asc']) && !isset($this->orders['crime_name_desc']) && $this->orders['crime_name_asc'] == 1)
            $query->orderBy(['crime_name' => SORT_ASC]);

        if (isset($this->orders['crime_name_desc']) && !isset($this->orders['crime_name_asc']) && $this->orders['crime_name_desc'] == 1)
            $query->orderBy(['crime_name' => SORT_DESC]);

        /*** crime_number ***/
        if (isset($this->orders['crime_number_asc'])  && !isset($this->orders['crime_number_desc']) && $this->orders['crime_number_asc'] == 1)
            $query->orderBy(['crime_number' => SORT_ASC]);

        if (isset($this->orders['crime_number_desc'])  && !isset($this->orders['crime_number_asc']) && $this->orders['crime_number_desc'] == 1)
            $query->orderBy(['crime_number' => SORT_DESC]);

        /*** quantity ***/
        if (isset($this->orders['quantity_asc'])  && !isset($this->orders['quantity_desc']) && $this->orders['quantity_asc'] == 1)
            $query->orderBy(['quantity' => SORT_ASC]);

        if (isset($this->orders['quantity_desc'])  && !isset($this->orders['quantity_asc']) && $this->orders['quantity_desc'] == 1)
            $query->orderBy(['quantity' => SORT_DESC]);

        return $dataProvider;
    }
}