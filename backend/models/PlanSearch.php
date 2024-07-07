<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Plan;

/**
 * PlanSearch represents the model behind the search form of `backend\models\Plan`.
 */
class PlanSearch extends Plan
{
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'customer_id', 'route_id', 'status', 'company_id', 'branch_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['journal_no', 'trans_date', 'description'], 'safe'],
            [['globalSearch'],'string'],
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
        $query = Plan::find();

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
            'customer_id' => $this->customer_id,
            'route_id' => $this->route_id,
            'status' => $this->status,
            'company_id' => $this->company_id,
            'branch_id' => $this->branch_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        if($this->globalSearch != ''){
            $query->orFilterWhere(['like', 'journal_no', $this->globalSearch])
                ->orFilterWhere(['like', 'description', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
