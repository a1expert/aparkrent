<?php

namespace frontend\models;

class Faq extends \common\models\Faq
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'answer'], 'string'],
            [['sort'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'sort' => 'Sort',
        ];
    }
}
