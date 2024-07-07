<?php

namespace backend\models;

use backend\models\Salecomcon;
use common\models\QuerySaleFinished;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SalecomconSearch represents the model behind the search form of `backend\models\Salecomcon`.
 */
class OrderfinishedSearch extends QuerySaleFinished
{
    public $globalSearch;

    public function rules()
    {
        return [
            [['id', 'company_id', 'branch_id', 'product_id', 'route_id'], 'integer'],
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
        $query = QuerySaleFinished::find();

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

        if(isset($_SESSION['user_company_id'])){
            $query->andFilterWhere(['company_id'=>$_SESSION['user_company_id']]);
        }
        if(isset($_SESSION['user_branch_id'])){
            $query->andFilterWhere(['branch_id'=>$_SESSION['user_branch_id']]);
        }

        $sale_date = null;
        if ($this->order_date != null) {
            $x_date = explode('/', $this->order_date);
            $sale_date = date('Y-m-d');
            if (count($x_date) > 1) {
                $sale_date = $x_date[2] . '/' . $x_date[1] . '/' . $x_date[0];
            }
            $this->order_date = date('Y-m-d', strtotime($sale_date));
            $query->andFilterWhere(['date(order_date)' => date('Y-m-d', strtotime($sale_date))]);
        }else{
            $this->order_date = date('Y-m-d');
            $query->andFilterWhere(['date(order_date)' => date('Y-m-d')]);
        }

        if($this->globalSearch != ''){
            $query->orFilterWhere(['like', 'order_no', $this->globalSearch])
                ->orFilterWhere(['like', 'route_name', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
