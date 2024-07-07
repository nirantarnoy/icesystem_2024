<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Paymentreceive;

/**
 * PaymentreceiveSearch represents the model behind the search form of `backend\models\Paymentreceive`.
 */
class PaymentreceiveSearch extends Paymentreceive
{
    public $globalSearch, $route_id;

    public function rules()
    {
        return [
            [['id', 'customer_id', 'created_at', 'crated_by', 'updated_at', 'updated_by', 'status'], 'integer'],
            [['trans_date', 'journal_no','route_id'], 'safe'],
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
        $query = Paymentreceive::find();
        $query->join('inner join', 'query_customer_info','payment_receive.customer_id = query_customer_info.customer_id');
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
            'id' => $this->id,
           // 'trans_date' => $this->trans_date,
            'customer_id' => $this->customer_id,
            'created_at' => $this->created_at,
            'crated_by' => $this->crated_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
           // 'query_customer_info.rt_id' => $this->route_id,
            'status' => $this->status,
        ]);

        if($this->trans_date != null || $this->trans_date != ''){
            $x_date = explode('/', $this->trans_date);
            $t_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $t_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $tx_date = date('Y-m-d', strtotime($t_date));
            $query->andFilterWhere(['date(trans_date)' => $tx_date]);
        }else{
            $query->andFilterWhere(['date(trans_date)' => date('Y-m-d')]);
        }

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        if ($this->route_id != '') {
            $query->andFilterWhere(['query_customer_info.rt_id'=>$this->route_id]);

        }

        if ($this->globalSearch != '') {
            $query->orFilterWhere(['like', 'journal_no', $this->globalSearch])
                ->orFilterWhere(['like', 'query_customer_info.cus_name', $this->globalSearch]);

        }

        return $dataProvider;
    }
}
