<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PageStatistic as PageStatisticModel;

/**
 * PageStatistic represents the model behind the search form about `app\models\PageStatistic`.
 */
class PageStatistic extends PageStatisticModel
{

    public function formName()
    {
        return '';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'url', 'page_title'], 'safe'],
            [['count', 'unique_count', 'time'], 'integer'],
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
        $query = PageStatisticModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            $query->where('1=0');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'count' => $this->count,
            'unique_count' => $this->unique_count,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'page_title', $this->page_title]);

        return $dataProvider;
    }
}
