<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Customerrequest;

/**
 * CustomerrequestSearch represents the model behind the search form of `backend\models\Customerrequest`.
 */
class CustomerrequestSearch extends Customerrequest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_ref_id', 'moo', 'district_id', 'city_id', 'province_id', 'route_id', 'route_num', 'payment_method_id', 'credit_term', 'after_invoice_day', 'user_box', 'marget_emp_id', 'is_approve', 'approve_emp_id', 'is_shop_place', 'emp_operate_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['journal_no', 'trans_date', 'customer_name', 'idcard_no', 'address', 'phone', 'company_name', 'start_date', 'sale_price', 'remark', 'account_no', 'account_credit_no', 'market_emp_date', 'approve_date'], 'safe'],
            [['age'], 'number'],
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
        $query = Customerrequest::find();

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
            'trans_date' => $this->trans_date,
            'customer_ref_id' => $this->customer_ref_id,
            'age' => $this->age,
            'moo' => $this->moo,
            'district_id' => $this->district_id,
            'city_id' => $this->city_id,
            'province_id' => $this->province_id,
            'route_id' => $this->route_id,
            'route_num' => $this->route_num,
            'start_date' => $this->start_date,
            'payment_method_id' => $this->payment_method_id,
            'credit_term' => $this->credit_term,
            'after_invoice_day' => $this->after_invoice_day,
            'user_box' => $this->user_box,
            'marget_emp_id' => $this->marget_emp_id,
            'market_emp_date' => $this->market_emp_date,
            'is_approve' => $this->is_approve,
            'approve_emp_id' => $this->approve_emp_id,
            'approve_date' => $this->approve_date,
            'is_shop_place' => $this->is_shop_place,
            'emp_operate_id' => $this->emp_operate_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'journal_no', $this->journal_no])
            ->andFilterWhere(['like', 'customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'idcard_no', $this->idcard_no])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'sale_price', $this->sale_price])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'account_no', $this->account_no])
            ->andFilterWhere(['like', 'account_credit_no', $this->account_credit_no]);

        return $dataProvider;
    }
}
