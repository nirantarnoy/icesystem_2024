<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customer;
use yii\web\Session;

class CustomerSearch extends Customer
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'customer_group_id', 'customer_type_id', 'delivery_route_id', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['code', 'name', 'description', 'location_info', 'active_date', 'logo', 'shop_photo'], 'safe'],
            [['globalSearch'], 'string']
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
        $query = Customer::find();

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
      //  $query->andFilterWhere([
//            'id' => $this->id,
//            'customer_group_id' => $this->customer_group_id,
//            'customer_type_id' => $this->customer_type_id,
//            'delivery_route_id' => $this->delivery_route_id,
//            'active_date' => $this->active_date,
//            'status' => $this->status,
//            'company_id' => $this->company_id,
//            'branch_id' => $this->branch_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
      //  ]);


        if ($this->customer_group_id != null) {
            $query->andFilterWhere(['customer_group_id' => $this->customer_group_id]);
        }
        if ($this->customer_type_id != null) {
            $query->andFilterWhere(['customer_type_id' => $this->customer_type_id]);
        }
        if ($this->delivery_route_id != null) {
            $query->andFilterWhere(['delivery_route_id' => $this->delivery_route_id]);
        }

        if ($this->globalSearch != '') {
            $query->orFilterWhere(['like', 'code', $this->globalSearch])
                ->orFilterWhere(['like', 'name', $this->globalSearch])
                ->orFilterWhere(['like', 'description', $this->globalSearch]);
        }

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        return $dataProvider;
    }
}
