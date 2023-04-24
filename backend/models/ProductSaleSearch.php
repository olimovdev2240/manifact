<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductSale;

/**
 * ProductSaleSearch represents the model behind the search form of `backend\models\ProductSale`.
 */
class ProductSaleSearch extends ProductSale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'base_id', 'contractor_id', 'office_id', 'convertme'], 'integer'],
            [['amount', 'exchange_amount', 'amount_convert'], 'number'],
            [['date', 'products', 'services'], 'safe'],
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
        $query = ProductSale::find()->orderBy(['id'=>SORT_DESC]);

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
            'base_id' => $this->base_id,
            'contractor_id' => $this->contractor_id,
            'office_id' => $this->office_id,
            'amount' => $this->amount,
            'exchange_amount' => $this->exchange_amount,
            'convertme' => $this->convertme,
            'amount_convert' => $this->amount_convert,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'products', $this->products])
            ->andFilterWhere(['like', 'services', $this->services]);

        return $dataProvider;
    }
}
