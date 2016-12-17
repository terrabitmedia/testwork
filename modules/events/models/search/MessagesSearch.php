<?php

namespace app\modules\events\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\events\models\Messages;

/**
 * MessagesSearch represents the model behind the search form of `app\modules\events\models\Messages`.
 */
class MessagesSearch extends Messages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_id', 'user_id', 'provider_id', 'notice_id'], 'integer'],
            [['status', 'text', 'title', 'from', 'to'], 'safe'],
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
        $query = Messages::find();

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
            'message_id' => $this->message_id,
            'user_id' => $this->user_id,
            'provider_id' => $this->provider_id,
            'notice_id' => $this->notice_id,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'from', $this->from])
            ->andFilterWhere(['like', 'to', $this->to]);

        return $dataProvider;
    }
}
