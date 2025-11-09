<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Assetsitem;

/**
 * AssetsitemSearch represents the model behind the search form of `backend\models\Assetsitem`.
 */
class AssetsitemSearch extends Assetsitem
{
    public $globalSearch,$route_id;

    public function rules()
    {
        return [
            [['id', 'status', 'company_id', 'branch_id', 'created_at', 'created_by', 'updated_at', 'updated_by','route_id'], 'integer'],
            [['asset_no', 'asset_name', 'description'], 'safe'],
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
        $query = Assetsitem::find();

        // add conditions that should always apply here

        $query->join('left join', 'customer_asset','assets.id = customer_asset.product_id');
        $query->join('left join','query_customer_info','customer_asset.customer_id = query_customer_info.customer_id');

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
//        $query->andFilterWhere([
//            'assets.id' => $this->id,
//            'assets.status' => $this->status,
//            'assets.company_id' => $this->company_id,
//            'assets.branch_id' => $this->branch_id,
//            'assets.created_at' => $this->created_at,
//            'assets.created_by' => $this->created_by,
//            'assets.updated_at' => $this->updated_at,
//            'assets.updated_by' => $this->updated_by,
//        ]);

        if($this->route_id !=null){
            $query->andFilterWhere(['query_customer_info.rt_id' => $this->route_id]);
        }

        if($this->globalSearch !=null || $this->globalSearch != ''){
            $query->orFilterWhere(['like', 'asset_no', $this->globalSearch])
                ->orFilterWhere(['like', 'asset_name', $this->globalSearch])
              //  ->orFilterWhere(['like', 'query_customer_info.route_code', $this->globalSearch])
                ->orFilterWhere(['like', 'description', $this->globalSearch]);
        }



        return $dataProvider;
    }
}
