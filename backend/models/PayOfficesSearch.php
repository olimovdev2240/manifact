<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PayOffices;

/**
 * PayOfficesSearch represents the model behind the search form of `backend\models\PayOffices`.
 */
class PayOfficesSearch extends PayOffices
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bank', 'section_id', 'exchange', 'status'], 'integer'],
            [['code', 'name', 'remains_sum', 'remains_usd'], 'safe'],
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
        $query = PayOffices::find()->orderBy(['id'=>SORT_DESC]);

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
            'bank' => $this->bank,
            'section_id' => $this->section_id,
            'remains_sum' => $this->remains_sum,
            'remains_usd' => $this->remains_usd,
            'exchange' => $this->exchange,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
