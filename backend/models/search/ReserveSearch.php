<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Reserve;

/**
 * Reserve represents the model behind the search form about `backend\models\Reserve`.
 */
class ReserveSearch extends Reserve
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'delivery_date', 'return_date', 'status', 'lead_status'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Reserve::find();

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
            'model_id' => $this->model_id,
            'return_date' => $this->return_date,
            'delivery_date' => $this->delivery_date,
            'price' => $this->price,
            'status' => $this->status,
        ]);

        $query->andWhere(['<>', 'status', self::STATUS_ACCEPTED]);
        $query->andWhere(['<>', 'status', self::STATUS_DELETED]);
        $query->andWhere(['<>', 'status', self::STATUS_REJECTED]);

        $query->orderBy('status, id DESC');

        return $dataProvider;
    }

    public function searchLead($params)
    {
        $query = Reserve::find();

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
            'model_id' => $this->model_id,
            'return_date' => $this->return_date,
            'delivery_date' => $this->delivery_date,
            'price' => $this->price,
            'status' => Reserve::STATUS_ACCEPTED,
            'lead_status' => $this->lead_status,
        ]);
        $query->andWhere(['<>', 'lead_status', Reserve::LEAD_STATUS_CLOSE]);

        $query->andWhere(['<>', 'status', self::STATUS_DELETED]);
        $query->orderBy('status, id DESC');


        return $dataProvider;
    }
}
