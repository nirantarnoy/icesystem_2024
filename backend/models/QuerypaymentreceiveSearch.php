<?php

namespace backend\models;

use common\models\QueryPaymentReceive;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SalecomconSearch represents the model behind the search form of `backend\models\Salecomcon`.
 */
class QuerypaymentreceiveSearch extends QueryPaymentReceive
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['journal_no', 'trans_date'], 'safe'],
            [['payment_amount'], 'number'],
            [['globalSearch', 'order_no', 'customer_code', 'customer_name'], 'string']
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
        $query = QueryPaymentReceive::find();

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
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'sale_price' => $this->sale_price,
//            'com_extra' => $this->com_extra,
//            'status' => $this->status,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'created_by' => $this->created_by,
//            'updated_by' => $this->updated_by,
//        ]);

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        if ($this->globalSearch != '') {
            $query->andFilterWhere(['OR',['like', 'journal_no', $this->globalSearch],['like', 'order_no', $this->globalSearch],['like', 'customer_name', $this->globalSearch]]);
        }


        return $dataProvider;
    }
}
