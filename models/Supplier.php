<?php namespace app\models;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * Class Supplier
 *
 * @property integer $id
 * @property string  $name
 * @property string  $code
 * @property string  $t_status
 *
 * @package app\models
 */
class Supplier extends ActiveRecord
{

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            [['id', 'name', 'code', 't_status'], 'safe'],
        ];
    }

    /**
     * Returns the attribute labels.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            't_status' => 'Status',
        ];
    }

    /**
     * 构建数据提供者
     *
     * @param $params
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pagesize' => 10,
            ],
            'sort'       => ['attributes' => ['']],
        ]);

        //筛选参数校验
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        //筛选
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['t_status' => $this->t_status]);

        return $dataProvider;
    }

}
