<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AutoModel;

/**
 * AutoModelSearch represents the model behind the search form about `backend\models\AutoModel`.
 */
class AutoModelSearch extends AutoModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'mark_id', 'class_id'], 'integer'],
            [['title', 'description', 'image', 'equipment', 'engine', 'audio'], 'safe'],
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
        $query = AutoModel::find();

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
            'mark_id' => $this->mark_id,
            'class_id' => $this->class_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'equipment', $this->equipment])
            ->andFilterWhere(['like', 'engine', $this->engine])
            ->andFilterWhere(['like', 'audio', $this->audio]);

        return $dataProvider;
    }
}
