<?php

namespace backend\models;

use common\models\QueryIssue;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Journalissue;

/**
 * JournalissueSearch represents the model behind the search form of `backend\models\Journalissue`.
 */
class IssuereportSearch extends QueryIssue
{
   public $globalSearch, $from_date, $to_date;
    public function rules()
    {
        return [
            [['id', 'status', 'car_ref_id', 'company_id', 'branch_id', 'reason_id', 'user_confirm', 'product_id', 'warehouse_id', 'location_id', 'line_status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'line_id'], 'integer'],
            [['trans_date','order_date','from_date','to_date', 'delivery_route_id','temp_update'], 'safe'],
            [['qty'], 'number'],
            [['journal_no'], 'string', 'max' => 255],
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

    public function search($params)
    {
        $query = QueryIssue::find();

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
//            'trans_date' => $this->trans_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
          // 'delivery_route_id'=> $this->delivery_route_id,
          //  'updated_by' => $this->updated_by,
        ]);

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        if($this->updated_by != null){
            $query->andFilterWhere(['updated_by' => $this->updated_by]);
        }

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
        if($this->delivery_route_id != null){
           // $ids = explode(',', $this->delivery_route_id);
            $query->andFilterWhere(['in','delivery_route_id',$this->delivery_route_id]);
        }

        $query->andFilterWhere(['like', 'journal_no', $this->globalSearch]);

        return $dataProvider;
    }
}
