<?php
/**
 * 文章搜索模型
 * 
 * @author 组员C
 * @date 2025-12-08
 */

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PreNewsArticle;

class PreNewsArticleSearch extends PreNewsArticle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aid', 'cid', 'uid', 'views', 'likes', 'is_top', 'is_hot', 'status'], 'integer'],
            [['title', 'summary', 'content', 'source', 'author', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * 创建数据提供者
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PreNewsArticle::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'aid' => $this->aid,
            'cid' => $this->cid,
            'uid' => $this->uid,
            'status' => $this->status,
            'is_top' => $this->is_top,
            'is_hot' => $this->is_hot,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'source', $this->source]);

        return $dataProvider;
    }
}

