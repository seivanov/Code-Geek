<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Clients;

/**
 * ClientsSearch represents the model behind the search form about `\common\models\Clients`.
 */
class ClientsSearch extends Clients
{

    public $count = 0;
    public $orderAmount;
    public $orderCount;
    public $fromcount;
    public $tocount;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'register_at', 'count'], 'integer'],
            [['fio'], 'safe'],
            [['orderAmount'], 'safe'],
            [['orderCount'], 'safe'],
            [['fromcount'], 'safe'],
            [['tocount'], 'safe']
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

        $query = Clients::find();

        $subQuery = Orders::find()
            ->select('client_id, SUM(summ) as order_amount, COUNT(id) as order_count')
            ->groupBy('client_id');
        $query->leftJoin(['orderSum' => $subQuery], 'orderSum.client_id = id');

        $subQuery = Orders::find()
            ->select('client_id, id as order_id')
            ->where('id IN (SELECT MAX(id) FROM orders GROUP BY client_id)');
        $query->leftJoin(['lastorder' => $subQuery], 'lastorder.client_id = id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
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
            'status' => $this->status,
            'register_at' => $this->register_at,
        ]);

        $query->andFilterWhere(['>=', 'order_count', $this->fromcount]);
        $query->andFilterWhere(['<=', 'order_count', $this->tocount]);

        $query->andFilterWhere(['like', 'fio', $this->fio]);

        $query->orderBy(['order_id' => SORT_ASC]);

        return $dataProvider;
    }
}
