<?php

namespace backend\models;

use backend\models\Company;
use common\models\QuerySaleByCustomer;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * CompanySearch represents the model behind the search form of `backend\models\Company`.
 */
class CustomersalehistorySearch extends QuerySaleByCustomer
{
    public $globalSearch;
    public function rules()
    {
        return [
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
        $query = QuerySaleByCustomer::find();

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
        if($this->globalSearch != ''){
            $query->orFilterWhere(['like', 'order_date', $this->globalSearch])
                ->orFilterWhere(['like', 'order_no', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
