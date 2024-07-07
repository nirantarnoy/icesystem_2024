<?php

namespace backend\models;

use backend\models\Paymentmethod;
use common\models\QuerySaleorderByCustomerLoanSum;
use common\models\QuerySaleorderByCustomerLoanSumNew;
use common\models\QuerySaleorderByRoute;
use yii\base\BaseObject;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use \common\models\QuerySaleTransData;

/**
 * PaymentmethodSearch represents the model behind the search form of `backend\models\Paymentmethod`.
 */
class SaleorderCustomerLoanSearch extends QuerySaleorderByCustomerLoanSumNew
{
    public $globalSearch;
    public $car_selected = [];
    public $customer_selected = [];

    public function rules()
    {
        return [
//            [['id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
//            [['code', 'name', 'note'], 'safe'],
//            [['globalSearch'],'string']
            [['customer_id', 'customer_type_id', 'company_id', 'branch_id', 'car_ref_id'], 'integer'],
            [['car_selected', 'rt_id', 'customer_selected'], 'safe']
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
        $query = QuerySaleorderByCustomerLoanSumNew::find();

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

//        $query->andFilterWhere([
//            'customer_id' => $this->customer_id,
//            'rt_id' => $this->rt_id,
//            'customer_type_id' => $this->customer_type_id,
//            'car_ref_id' => $this->car_ref_id
//            //'!=','route_code','NULL'
//        ]);

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        if($this->car_selected != null ){
            $query->andFilterWhere(['IN', 'rt_id', $this->car_selected]);
        }
        if($this->customer_selected != null ){
            $query->andFilterWhere(['IN', 'customer_id', $this->customer_selected]);
        }



        return $dataProvider;
    }
}
