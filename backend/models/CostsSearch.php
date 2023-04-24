<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Costs;

/**
 * CostsSearch represents the model behind the search form of `backend\models\Costs`.
 */
class CostsSearch extends Costs
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'office_id', 'user_id', 'current_rate'], 'integer'],
            [['remains_sum', 'cost_sum', 'remains_usd', 'cost_usd'], 'number'],
            [['date', 'salary', 'expense'], 'safe'],
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
        $query = Costs::find();

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
            'office_id' => $this->office_id,
            'user_id' => $this->user_id,
            'remains_sum' => $this->remains_sum,
            'cost_sum' => $this->cost_sum,
            'remains_usd' => $this->remains_usd,
            'cost_usd' => $this->cost_usd,
            'date' => $this->date,
            'current_rate' => $this->current_rate,
        ]);

        $query->andFilterWhere(['like', 'salary', $this->salary])
            ->andFilterWhere(['like', 'expense', $this->expense]);

        return $dataProvider;
    }
}
