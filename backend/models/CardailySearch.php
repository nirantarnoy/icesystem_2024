<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Cardaily;

/**
 * CardailySearch represents the model behind the search form of `backend\models\Cardaily`.
 */
class CardailySearch extends Cardaily
{
    public $route_id;
    public $car_name;

    public function rules()
    {
        return [
            [['id', 'car_id', 'employee_id', 'is_driver', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['trans_date'], 'safe'],
            [['route_id'], 'integer'],
            [['car_name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
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
        $query = Cardaily::find()->select(['car_daily.id', 'car_daily.car_id', 'car_daily.employee_id', 'sale_group.delivery_route_id', 'car.plate_number', 'car_daily.trans_date'])->innerJoin('car', 'car.id=car_daily.car_id')
            ->innerJoin('sale_group', 'car.sale_group_id = sale_group.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        //    $query->andFilterWhere([
//            'id' => $this->id,
//            'car_id' => $this->car_id,
//            'employee_id' => $this->employee_id,
//            'is_driver' => $this->is_driver,
//            'status' => $this->status,
//            'trans_date' => $this->trans_date,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
        //     ]);



        if ($this->route_id != null) {
            $query->andFilterWhere(['sale_group.delivery_route_id' => $this->route_id]);
        }
        if ($this->car_name != '') {
            // $query->andFilterWhere(['OR',['LIKE','car.name', $this->car_name],['LIKE','car.description', $this->car_name]]);
            $query->andFilterWhere(['LIKE', 'car.plate_number', $this->car_name]);
        }
        if ($this->trans_date != null) {
            $x_date = explode('/', $this->trans_date);
            $f_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $f_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }

            $this->trans_date = date('Y-m-d', strtotime($f_date));
            $query->andFilterWhere(['date(car_daily.trans_date)' => $this->trans_date]);
        } else {
            $this->trans_date = date('Y-m-d');
            $query->andFilterWhere(['date(car_daily.trans_date)' => $this->trans_date]);
        }

        return $dataProvider;
    }
}
