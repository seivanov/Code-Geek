<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property string $fio
 * @property integer $status
 * @property integer $register_at
 */
class Clients extends \yii\db\ActiveRecord
{

    public $fromcount;
    public $tocount;

    public $count = 0;
    public $sum;

    public $sortlastorder = 0;

    private $status = [
        0 => 'Новый клиент',
        1 => 'Вип клиент',
        2 => 'Постоянный клиент'
    ];

    public function getStatus($status) {

        if(isset($this->status[$status]))
            return \yii\helpers\html::tag('div', $this->status[$status], ['class' => 'status']);

        return '';

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fio', 'register_at'], 'required'],
            [['status', 'register_at', 'fromcount', 'tocount', 'count', 'sortlastorder'], 'integer'],
            [['fio'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Фио клиента',
            'status' => 'Статус клиента',
            'last_order' => 'Последний заказ',
            'orders_count' => 'Всего заказов',
            'orders_summ' => 'Сумма заказов',
            'register_at' => 'Зарегистрирован',
            'orderAmount' => 'Сумма заказов'
        ];
    }

    public function getOrderAmount()
    {
        return $this->hasMany(Orders::className(), ['client_id' => 'id'])->sum('summ');
    }

    public function getOrderCount()
    {
        return $this->hasMany(Orders::className(), ['client_id' => 'id'])->count();
    }

    // -----------------------

    public function getOrders() {
        return $this->hasOne(Orders::className(), ['client_id' => 'id']);
    }

    public function getLastOrder() {
        return \common\models\Orders::find()->where(['client_id' => $this->id])->orderBy(['id' => SORT_DESC])->asArray()->one();
    }

    public function getOrdersSumm() {
        return \common\models\Orders::find()->where(['client_id' => $this->id])->sum('summ');
    }

    public function getOrdersCount() {
        return \common\models\Orders::find()->where(['client_id' => $this->id])->count();
    }

}
