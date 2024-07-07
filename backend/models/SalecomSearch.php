<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Salecom;

/**
 * SalecomSearch represents the model behind the search form of `backend\models\Salecom`.
 */
class SalecomSearch extends Salecom
{
   public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'emp_qty', 'status', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['code', 'name'], 'safe'],
            [['com_extra'], 'number'],
            [['globalSearch'],'string']
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
        $query = Salecom::find();

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
            'emp_qty' => $this->emp_qty,
            'com_extra' => $this->com_extra,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
        ]);

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        if($this->globalSearch != ''){
            $query->orFilterWhere(['like', 'code', $this->globalSearch])
                ->orFilterWhere(['like', 'name', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
