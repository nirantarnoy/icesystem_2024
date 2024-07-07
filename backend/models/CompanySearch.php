<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Company;

/**
 * CompanySearch represents the model behind the search form of `backend\models\Company`.
 */
class CompanySearch extends Company
{
    public $globalSearch;
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'tenant_id', 'status'], 'integer'],
            [['code', 'name', 'engname', 'taxid', 'logo'], 'safe'],
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
        $query = Company::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'tenant_id' => $this->tenant_id,
            'status' => $this->status,
        ]);



        if($this->globalSearch != ''){
            $query->orFilterWhere(['like', 'code', $this->globalSearch])
                ->orFilterWhere(['like', 'name', $this->globalSearch])
                ->orFilterWhere(['like', 'engname', $this->globalSearch])
                ->orFilterWhere(['like', 'taxid', $this->globalSearch]);
        }


        return $dataProvider;
    }
}
