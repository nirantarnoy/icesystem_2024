<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Dailycount;

/**
 * DailycountSearch represents the model behind the search form of `backend\models\Dailycount`.
 */
class DailycountSearch extends Dailycount
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'status', 'company_id', 'branch_id', 'user_id', 'warehouse_id', 'posted'], 'integer'],
            [['trans_date', 'journal_no'], 'safe'],
            [['qty'], 'number'],
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
        $query = Dailycount::find();

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
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'status' => $this->status,
            'company_id' => $this->company_id,
            'branch_id' => $this->branch_id,
            'user_id' => $this->user_id,
            'warehouse_id' => $this->warehouse_id,
            'posted' => $this->posted,
        ]);

        $query->andFilterWhere(['like', 'journal_no', $this->journal_no]);

        return $dataProvider;
    }
}
