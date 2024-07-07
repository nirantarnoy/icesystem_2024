<?php

namespace backend\models;

use backend\models\Salecomcon;
use common\models\QuerySaleFinished;
use common\models\QuerySaleFinishedSummary;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SalecomconSearch represents the model behind the search form of `backend\models\Salecomcon`.
 */
class OrderfinishedsumSearch extends QuerySaleFinished
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'company_id', 'branch_id', 'route_id'], 'integer'],
            [['order_date'], 'safe'],
            [['qty', 'sale_qty', 'avl_qty'], 'number'],
            [['order_no', 'route_name'], 'string', 'max' => 255],
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
        $query = QuerySaleFinishedSummary::find();

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
            'order_no' => $this->order_no,
            'route_name' => $this->route_name
        ]);

        if (!empty(\Yii::$app->user->identity->company_id)) {
            $query->andFilterWhere(['company_id' => \Yii::$app->user->identity->company_id]);
        }
        if (!empty(\Yii::$app->user->identity->branch_id)) {
            $query->andFilterWhere(['branch_id' => \Yii::$app->user->identity->branch_id]);
        }

        if($this->globalSearch != ''){
            $query->orFilterWhere(['like', 'order_no', $this->globalSearch])
                ->orFilterWhere(['like', 'route_name', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
