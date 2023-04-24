<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OfficeOutlay;

/**
 * OfficeOutlaySearch represents the model behind the search form of `backend\models\OfficeOutlay`.
 */
class OfficeOutlaySearch extends OfficeOutlay
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'office_id', 'contractor_id', 'exchange'], 'integer'],
            [['amount', 'current_rate', 'exchange_sum'], 'number'],
            [['comment', 'date'], 'safe'],
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
        $query = OfficeOutlay::find()->orderBy(['id'=>SORT_DESC]);

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
            'user_id' => $this->user_id,
            'office_id' => $this->office_id,
            'contractor_id' => $this->contractor_id,
            'amount' => $this->amount,
            'exchange' => $this->exchange,
            'current_rate' => $this->current_rate,
            'date' => $this->date,
            'exchange_sum' => $this->exchange_sum,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
