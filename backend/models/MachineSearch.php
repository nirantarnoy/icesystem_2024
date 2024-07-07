<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Machine;

/**
 * MachineSearch represents the model behind the search form of `backend\models\Machine`.
 */
class MachineSearch extends Machine
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'warehouse_id', 'rows', 'sub_rows', 'company_id', 'branch_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['machine_no', 'name', 'description'], 'safe'],
            [['globalSearch'], 'string'],
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
        $query = Machine::find();

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
            'warehouse_id' => $this->warehouse_id,
            'rows' => $this->rows,
            'sub_rows' => $this->sub_rows,
            'company_id' => $this->company_id,
            'branch_id' => $this->branch_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->orFilterWhere(['like', 'machine_no', $this->globalSearch])
            ->orFilterWhere(['like', 'name', $this->globalSearch])
            ->orFilterWhere(['like', 'description', $this->globalSearch]);

        return $dataProvider;
    }
}
