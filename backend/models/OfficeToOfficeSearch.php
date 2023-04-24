<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OfficeToOffice;

/**
 * OfficeToOfficeSearch represents the model behind the search form of `backend\models\OfficeToOffice`.
 */
class OfficeToOfficeSearch extends OfficeToOffice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'debit_office', 'outlay_office', 'exchange', 'user_id'], 'integer'],
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
        $query = OfficeToOffice::find()->orderBy(['id'=>SORT_DESC]);

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
            'debit_office' => $this->debit_office,
            'outlay_office' => $this->outlay_office,
            'amount' => $this->amount,
            'exchange' => $this->exchange,
            'current_rate' => $this->current_rate,
            'exchange_sum' => $this->exchange_sum,
            'date' => $this->date,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
