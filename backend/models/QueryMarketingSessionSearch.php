<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\QueryMarketingSession;

/**
 * QueryMarketingSessionSearch represents the model behind the search form of `backend\models\QueryMarketingSession`.
 */
class QueryMarketingSessionSearch extends QueryMarketingSession
{
    public $globalSearch;
    public $from_date;
    public $to_date;
    public $pageSize;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'route_id', 'rent_borrow_tank', 'collect_tank', 'user_id'], 'integer'],
            [['customer_name', 'check_in_time', 'check_out_time', 'created_at', 'activity_type', 'route_name', 'shop_name', 'activity_check_in_time', 'activity_check_out_time', 'start_time', 'end_time', 'event_detail', 'photo_path', 'username', 'fname', 'lname', 'globalSearch', 'from_date', 'to_date', 'pageSize'], 'safe'],
            [['check_in_lat', 'check_in_long', 'check_out_lat', 'check_out_long'], 'number'],
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
        $query = QueryMarketingSession::find();

        // add conditions that should always apply here

        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->pageSize ? ($this->pageSize == 'all' ? false : $this->pageSize) : 20,
            ],
        ]);

        $dataProvider->sort->attributes['id'] = [
            'asc' => ['query_marketing_session.id' => SORT_ASC],
            'desc' => ['query_marketing_session.id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['query_marketing_session.id'] = [
            'asc' => ['query_marketing_session.id' => SORT_ASC],
            'desc' => ['query_marketing_session.id' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['login_date'] = [
            'asc' => ['login_date' => SORT_ASC],
            'desc' => ['login_date' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['fname'] = [
            'asc' => ['query_marketing_session.fname' => SORT_ASC],
            'desc' => ['query_marketing_session.fname' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['lname'] = [
            'asc' => ['query_marketing_session.lname' => SORT_ASC],
            'desc' => ['query_marketing_session.lname' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['route_name'] = [
            'asc' => ['query_marketing_session.route_name' => SORT_ASC],
            'desc' => ['query_marketing_session.route_name' => SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'query_marketing_session.id' => $this->id,
            'query_marketing_session.customer_id' => $this->customer_id,
            'query_marketing_session.check_in_lat' => $this->check_in_lat,
            'query_marketing_session.check_in_long' => $this->check_in_long,
            'query_marketing_session.check_out_lat' => $this->check_out_lat,
            'query_marketing_session.check_out_long' => $this->check_out_long,
            'query_marketing_session.check_in_time' => $this->check_in_time,
            'query_marketing_session.check_out_time' => $this->check_out_time,
            'query_marketing_session.created_at' => $this->created_at,
            'query_marketing_session.route_id' => $this->route_id,
            'query_marketing_session.activity_check_in_time' => $this->activity_check_in_time,
            'query_marketing_session.activity_check_out_time' => $this->activity_check_out_time,
            'query_marketing_session.start_time' => $this->start_time,
            'query_marketing_session.end_time' => $this->end_time,
            'query_marketing_session.rent_borrow_tank' => $this->rent_borrow_tank,
            'query_marketing_session.collect_tank' => $this->collect_tank,
            'query_marketing_session.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'query_marketing_session.customer_name', $this->customer_name])
            ->andFilterWhere(['like', 'query_marketing_session.activity_type', $this->activity_type])
            ->andFilterWhere(['like', 'query_marketing_session.route_name', $this->route_name])
            ->andFilterWhere(['like', 'query_marketing_session.shop_name', $this->shop_name])
            ->andFilterWhere(['like', 'query_marketing_session.event_detail', $this->event_detail])
            ->andFilterWhere(['like', 'query_marketing_session.photo_path', $this->photo_path])
            ->andFilterWhere(['like', 'query_marketing_session.username', $this->username])
            ->andFilterWhere(['like', 'query_marketing_session.fname', $this->fname])
            ->andFilterWhere(['like', 'query_marketing_session.lname', $this->lname]);
            
        if($this->globalSearch != ''){
            $query->andFilterWhere(['or',
                ['like', 'query_marketing_session.customer_name', $this->globalSearch],
                ['like', 'query_marketing_session.route_name', $this->globalSearch],
                ['like', 'query_marketing_session.shop_name', $this->globalSearch],
                ['like', 'query_marketing_session.fname', $this->globalSearch],
                ['like', 'query_marketing_session.lname', $this->globalSearch],
            ]);
        }

        return $dataProvider;
    }
}
