<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Contractors;

/**
 * ContractorsSearch represents the model behind the search form of `backend\models\Contractors`.
 */
class ContractorsSearch extends Contractors
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'section_id', 'group_id', 'type_id', 'price_type', 'status'], 'integer'],
            [['code', 'name', 'address', 'gender', 'tel', 'inn', 'corporation', 'mfo_bank', 'photo', 'special'], 'safe'],
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
        $query = Contractors::find()->orderBy(['id'=>SORT_DESC]);

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
            'section_id' => $this->section_id,
            'group_id' => $this->group_id,
            'type_id' => $this->type_id,
            'price_type' => $this->price_type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'inn', $this->inn])
            ->andFilterWhere(['like', 'corporation', $this->corporation])
            ->andFilterWhere(['like', 'mfo_bank', $this->mfo_bank])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'special', $this->special]);

        return $dataProvider;
    }
}
