<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Sequence;

/**
 * SequenceSearch represents the model behind the search form of `backend\models\Sequence`.
 */
class SequenceSearch extends Sequence
{
    public $globalSearch;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'plant_id', 'module_id', 'use_year', 'use_month', 'use_day', 'minimum', 'maximum', 'currentnum', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['prefix', 'symbol'], 'safe'],
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
        $query = Sequence::find();

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
            'plant_id' => $this->plant_id,
            'module_id' => $this->module_id,
            'use_year' => $this->use_year,
            'use_month' => $this->use_month,
            'use_day' => $this->use_day,
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
            'currentnum' => $this->currentnum,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);


        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        if ($this->globalSearch != '') {
            $query->orFilterWhere(['like', 'prefix', $this->globalSearch]);
        }

        return $dataProvider;
    }
}
