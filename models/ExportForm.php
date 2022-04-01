<?php namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ExportForm is the model behind the contact form.
 */
class ExportForm extends Model
{
    /**
     * @var array
     */
    public $fields = [];

    /**
     * @var string
     */
    public $condition;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['fields', 'required'],
            [['condition', 'fields'], 'safe'],
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
            'fields' => '导出字段',
        ];
    }

}
