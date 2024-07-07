<?php

namespace backend\models;

use backend\models\Paymentmethod;
use common\models\QuerySaleSummaryByEmp2;
use common\models\QuerySaleTransByEmp;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use \common\models\QuerySaleTransData;

/**
 * PaymentmethodSearch represents the model behind the search form of `backend\models\Paymentmethod`.
 */
class SalereportbyempSearch extends QuerySaleSummaryByEmp2
{
    public $globalSearch;

    public function rules()
    {
        return [
//            [['id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
//            [['code', 'name', 'note'], 'safe'],
//            [['globalSearch'],'string']

//            [['customer_id', 'order_channel_id', 'payment_method_id'], 'integer'],
            [['emp_id','order_channel_id'], 'safe'],
//            [['product_id'], 'safe']
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
        $query = QuerySaleSummaryByEmp2::find();

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
        $query->andFilterWhere([
//            'id' => $this->id,
//            'status' => $this->status,
//            'created_at' => $this->created_at,
//            'created_by' => $this->created_by,
//            'updated_at' => $this->updated_at,
//            'customer_id' => $this->customer_id,
//            'product_id' => $this->product_id,
//            'order_channel_id' => $this->order_channel_id,
//            'payment_method_id' => $this->payment_method_id,
  //           'emp_id' => $this->emp_id
//            '!=','route_code','NULL'
        ]);


        return $dataProvider;
    }
}
