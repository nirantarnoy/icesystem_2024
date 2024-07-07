<?php

namespace backend\models;

use common\models\QuerySalePosData;
use common\models\QuerySalePosPay;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SalegroupSearch represents the model behind the search form of `backend\models\Salegroup`.
 */
class SalepospaySearch extends QuerySalePosPay
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['code', 'payment_date', 'payment_amount'], 'safe'],
            [['globalSearch'], 'string']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = QuerySalePosPay::find();

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

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'status' => $this->status,
//            'created_at' => $this->created_at,
//            'created_by' => $this->created_by,
//            'updated_at' => $this->updated_at,
//            'updated_by' => $this->updated_by,
//        ]);
//        if ($this->globalSearch != '') {
//            $query->orFilterWhere(['like', 'code', $this->globalSearch])
//                ->orFilterWhere(['like', 'name', $this->globalSearch]);
//        }
        return $dataProvider;
    }
}
