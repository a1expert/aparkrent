<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Client;

/**
 * ClientSearch represents the model behind the search form about `backend\models\Client`.
 */
class ClientSearch extends Client
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'birthday', 'passport_date_issue'], 'integer'],
            [['phone', 'surname', 'name', 'email', 'patronymic', 'passport_series', 'passport_number', 'passport_place_issue', 'registration_place', 'residence_place', 'additional_phone', 'relative_phone', 'drive_license_series', 'drive_license_number', 'company_name', 'inn', 'kpp', 'ogrn', 'company_residence', 'post_in_company', 'fio_for_paper', 'account_number', 'bik', 'bank', 'correspondent_account', 'company_phone', 'company_email', 'status'], 'safe'],
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
        $query = Client::find();

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
            'type' => $this->type,
            'birthday' => $this->birthday,
            'passport_date_issue' => $this->passport_date_issue,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            ->andFilterWhere(['like', 'passport_series', $this->passport_series])
            ->andFilterWhere(['like', 'passport_number', $this->passport_number])
            ->andFilterWhere(['like', 'passport_place_issue', $this->passport_place_issue])
            ->andFilterWhere(['like', 'registration_place', $this->registration_place])
            ->andFilterWhere(['like', 'residence_place', $this->residence_place])
            ->andFilterWhere(['like', 'additional_phone', $this->additional_phone])
            ->andFilterWhere(['like', 'relative_phone', $this->relative_phone])
            ->andFilterWhere(['like', 'drive_license_series', $this->drive_license_series])
            ->andFilterWhere(['like', 'drive_license_number', $this->drive_license_number])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'inn', $this->inn])
            ->andFilterWhere(['like', 'kpp', $this->kpp])
            ->andFilterWhere(['like', 'ogrn', $this->ogrn])
            ->andFilterWhere(['like', 'company_residence', $this->company_residence])
            ->andFilterWhere(['like', 'post_in_company', $this->post_in_company])
            ->andFilterWhere(['like', 'fio_for_paper', $this->fio_for_paper])
            ->andFilterWhere(['like', 'account_number', $this->account_number])
            ->andFilterWhere(['like', 'bik', $this->bik])
            ->andFilterWhere(['like', 'bank', $this->bank])
            ->andFilterWhere(['like', 'correspondent_account', $this->correspondent_account])
            ->andFilterWhere(['like', 'company_phone', $this->company_phone])
            ->andFilterWhere(['like', 'company_email', $this->company_email]);

        $query->andWhere(['<>', 'status', Client::STATUS_DELETED]);

        $query->orderBy('id DESC');

        return $dataProvider;
    }
}
