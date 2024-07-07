<?php

namespace backend\models;

use common\models\QuerySaleorderByRouteDaily;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\Session;
class QuerySaleorderByRouteSearch extends QuerySaleorderByRouteDaily
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['route_id','company_id','branch_id','status','type_id'], 'integer'],
            [['route_code', 'car_code', 'car_name','order_date'], 'safe'],
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
        $query = QuerySaleorderByRouteDaily::find();

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
//            'customer_id' => $this->customer_id,
//            'customer_type' => $this->customer_type,
//            //   'order_date' => $this->order_date,
//            'vat_amt' => $this->vat_amt,
//            'vat_per' => $this->vat_per,
//            'order_total_amt' => $this->order_total_amt,
//            'emp_sale_id' => $this->emp_sale_id,
//            'car_ref_id' => $this->car_ref_id,
            'route_id' => $this->route_id,
//            'status' => $this->status,
//            'company_id' => $this->company_id,
//            'branch_id' => $this->branch_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
        ]);
//        if(isset($_SESSION['user_company_id'])){
//            $query->andFilterWhere(['orders.company_id'=>$_SESSION['user_company_id']]);
//        }
//        if(isset($_SESSION['user_branch_id'])){
//            $query->andFilterWhere(['orders.branch_id'=>$_SESSION['user_branch_id']]);
//        }

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }


//        if($this->order_date == null){
//            $this->order_date = date('Y-m-d');
//        }
        $sale_date = null;
        if ($this->order_date != null) {
            $x_date = explode('/', $this->order_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $this->order_date = date('Y-m-d', strtotime($sale_date));
            $query->andFilterWhere(['date(order_date)' => date('Y-m-d', strtotime($sale_date))]);
        }else{
            $this->order_date = date('Y-m-d');
            $query->andFilterWhere(['date(order_date)' => date('Y-m-d')]);
        }

        if ($this->globalSearch != '') {
            $query->orFilterWhere(['like', 'route_code', $this->globalSearch])
                ->orFilterWhere(['like', 'car_name', $this->globalSearch])
                ->orFilterWhere(['like', 'car_code', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
