<?php

namespace backend\models;

use backend\models\Paymentmethod;
use common\models\QuerySaleorderByRoute;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use \common\models\QuerySaleTransData;

/**
 * PaymentmethodSearch represents the model behind the search form of `backend\models\Paymentmethod`.
 */
class SaleorderbyrouteSearch extends QuerySaleorderByRoute
{
    public $globalSearch;

    public function rules()
    {
        return [
//            [['id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
//            [['code', 'name', 'note'], 'safe'],
//            [['globalSearch'],'string']
            [['customer_id', 'rt_id', 'payment_method_id'], 'integer'],
            [['order_date'], 'safe'],
            [['product_id'], 'safe']
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
        $query = QuerySaleorderByRoute::find();

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
            'customer_id' => $this->customer_id,
            'product_id' => $this->product_id,
            'rt_id' => $this->rt_id,
            'payment_method_id' => $this->payment_method_id
            //'!=','route_code','NULL'
        ]);

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        if($this->order_date != ''){
            $date_data = explode(' - ',$this->order_date);
            $fdate = null;
            $tdate = null;
            $f_date = null;
            $t_date = null;

            if($date_data > 1){
                $xdate = explode('/',$date_data[0]);
                if(count($xdate)>1){
                    $fdate = $xdate[2].'-'.$xdate[1].'-'.$xdate[0];
                }
                $xdate2 = explode('/',$date_data[1]);
                if(count($xdate2)>1){
                    $tdate = $xdate2[2].'-'.$xdate2[1].'-'.$xdate2[0];
                }
            }

            $f_date = date('Y-m-d',strtotime($fdate));
            $t_date = date('Y-m-d',strtotime($tdate));

            $query->andFilterWhere(['between','date(order_date)',$f_date, $t_date]);

            // $query->andFilterWhere(['<=','date(order_date)',$f_date]);
            // ->andFilterWhere(['<=','date(order_date)',$t_date]);

        }

//
//        if($this->globalSearch != ''){
//            $query->orFilterWhere(['like', 'code', $this->globalSearch])
//                ->orFilterWhere(['like', 'name', $this->globalSearch])
//                ->orFilterWhere(['like', 'note', $this->globalSearch]);
//        }


        return $dataProvider;
    }
}
