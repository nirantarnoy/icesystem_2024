<?php

namespace backend\models;

use backend\models\Orders;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersSearch represents the model behind the search form of `backend\models\Orders`.
 */
class OrdersposSearch extends Orders
{
    public $globalSearch, $from_date, $to_date;

    public function rules()
    {
        return [
            [['id', 'customer_id', 'customer_type', 'emp_sale_id', 'car_ref_id', 'order_channel_id', 'status', 'company_id', 'branch_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['order_no', 'order_date','from_date','to_date'], 'safe'],
            [['vat_amt', 'vat_per', 'order_total_amt'], 'number'],
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
        $query = Orders::find()
            ->join('left join', 'car', 'orders.car_ref_id = car.id')
            ->join('left join', 'customer', 'orders.customer_id = customer.id')
            ->join('left join', 'delivery_route', 'orders.order_channel_id=delivery_route.id');

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
        // $query->andFilterWhere([
        // 'created_by' => $this->created_by
//            'id' => $this->id,
//            'customer_id' => $this->customer_id,
//            'customer_type' => $this->customer_type,
//            //   'order_date' => $this->order_date,
//            'vat_amt' => $this->vat_amt,
//            'vat_per' => $this->vat_per,
//            'order_total_amt' => $this->order_total_amt,
//            'emp_sale_id' => $this->emp_sale_id,
//            'car_ref_id' => $this->car_ref_id,
//            'order_channel_id' => $this->order_channel_id,
//            'status' => $this->status,
//            'company_id' => $this->company_id,
//            'branch_id' => $this->branch_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
        //  ]);
        //       $query->andFilterWhere(['sale_channel_id' => 2]);

//        if($this->order_date == null){
//            $this->order_date = date('Y-m-d');
//        }
//        $sale_date = null;
//        if ($this->order_date != null) {
//            $x_date = explode('/', $this->order_date);
//            $sale_date = date('Y-m-d');
//            if (count($x_date) > 1) {
//                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
//            }
//            $this->order_date = date('Y-m-d', strtotime($sale_date));
//            $query->andFilterWhere(['order_date' => date('Y-m-d', strtotime($sale_date))]);
//        }

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['orders.company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['orders.branch_id' => \Yii::$app->user->identity->branch_id]);
        }

       // $query->andFilterWhere(['sale_channel_id' => 2]);
      //  $query->andFilterWhere(['>','orders.customer_id', 0 ]);
        $query->andFilterWhere([
            '=', 'orders.created_by', $this->created_by
        ]);

//        $f_date = null;
//        $t_date = null;
//
//        $dash_board = $this->order_date;
//        $x_date = explode('-', trim($dash_board));
//        if ($x_date != null) {
//            if (count($x_date) > 1) {
//                $ff_date = $x_date[0];
//                $tt_date = $x_date[1];
//
//                $fff_date = explode('/', trim($ff_date));
//                if (count($fff_date) > 0) {
//                    $f_date = $fff_date[2] . '-' . $fff_date[1] . '-' . $fff_date[0];
//                }
//                $ttt_date = explode('/', trim($tt_date));
//                if (count($ttt_date) > 0) {
//                    $t_date = $ttt_date[2] . '-' . $ttt_date[1] . '-' . $ttt_date[0];
//                }
//            }
//
//            $query->andFilterWhere(['AND', ['>=', 'date(order_date)', date('Y-m-d', strtotime($f_date))], ['<=', 'date(order_date)', date('Y-m-d', strtotime($t_date))]]);
//
//        }

        $is_admin = \backend\models\User::checkIsAdmin(\Yii::$app->user->id);

        include \Yii::getAlias("@backend/helpers/ChangeAdminDate.php");

        if($this->from_date != null && $this->to_date != null){
            $fx_datetime = explode(' ',$this->from_date);
            $tx_datetime = explode(' ',$this->to_date);

            $f_date = null;
            $f_time = null;
            $t_date = null;
            $t_time = null;

            $from_date_time = null;
            $to_date_time = null;

            if(count($fx_datetime) > 0){
                $f_date = $fx_datetime[0];
                $f_time = $fx_datetime[1];

                $x_date = explode('-', $f_date);
                $xx_date = date('Y-m-d');
                if (count($x_date) > 1) {
                    $xx_date = trim($x_date[1]) . '/' . trim($x_date[2]) . '/' . trim($x_date[0]);
                }
                $from_date_time = date('Y-m-d H:i:s',strtotime($xx_date.' '.$f_time));
                //$from_date_time = date('Y-m-d',strtotime($xx_date));
                $query->andFilterWhere(['>=','order_date', $from_date_time]);
            }

            if(count($tx_datetime) > 0){
                $t_date = $tx_datetime[0];
                $t_time = $tx_datetime[1];

                $n_date = explode('-', $t_date);
                $nn_date = date('Y-m-d');
                if (count($n_date) > 1) {
                    $nn_date = trim($n_date[1]) . '/' . trim($n_date[2]) . '/' . trim($n_date[0]);
                }
                $to_date_time = date('Y-m-d H:i:s',strtotime($nn_date.' '.$t_time));
                $query->andFilterWhere(['<=','order_date',$to_date_time]);
            }

        }else{
            $query->andFilterWhere(['>=', 'date(order_date)', date('Y-m-d')]);
            $query->andFilterWhere(['<=', 'date(order_date)', date('Y-m-d')]);
        }


        if ($this->globalSearch != '') {
            $query->orFilterWhere(['like', 'customer.name', $this->globalSearch]);
//            $query->orFilterWhere(['like', 'order_no', $this->globalSearch])
//                ->orFilterWhere(['like', 'customer.name', $this->globalSearch])
//                ->orFilterWhere(['like', 'car.name', $this->globalSearch])
//                ->orFilterWhere(['like', 'delivery_route.code', $this->globalSearch]);
        }


        return $dataProvider;
    }

}
