<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $client_id
 * @property double $summ
 * @property integer $created_at
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'created_at'], 'required'],
            [['client_id', 'created_at'], 'integer'],
            [['summ'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'summ' => 'Summ',
            'created_at' => 'Created At',
        ];
    }
}
