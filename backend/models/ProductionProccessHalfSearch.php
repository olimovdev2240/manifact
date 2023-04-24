<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ProductionProccess;

/**
 * ProductionProccessSearch represents the model behind the search form of `backend\models\ProductionProccess`.
 */
class ProductionProccessHalfSearch extends ProductionProccess
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'worker_id', 'stage_id', 'product_id', 'is_counted', 'is_defective', 'status'], 'integer'],
            [['packaging_type', 'photo', 'created_at', 'counted_at'], 'safe'],
            [['qty', 'salary'], 'number'],
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
        $query = ProductionProccess::find()
        ->leftJoin('products', 'products.id=production_proccess.product_id')
        ->where(['products.type_id' => 1, 'is_counted' => 0]);

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
            'worker_id' => $this->worker_id,
            'stage_id' => $this->stage_id,
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'salary' => $this->salary,
            'is_counted' => $this->is_counted,
            'created_at' => $this->created_at,
            'counted_at' => $this->counted_at,
            'is_defective' => $this->is_defective,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'packaging_type', $this->packaging_type])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
