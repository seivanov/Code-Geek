<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'My Yii Application';

$this->registerJsFile(
    '@web/js/grid.js',
    ['depends' => [\backend\assets\AppAsset::className()]]
);

?>
<div class="site-index">

    <div class="table-responsive">
        <div class="logo">
            <img src="/admin/img/logo.png">
        </div>
        <div class="select">
            <div class="table">
                <div class="cell">
                    <span class="all_clients clients active" status="">Все клиенты</span>
                    <span class="new_clients clients" status="0">Новые</span>
                    <span class="regular_clients clients" status="2">Постоянные</span>
                    <span class="vip_clients clients" status="1">Вип клиенты</span>
                </div>
            </div>
        </div>
        <div class="filter">
            <div class="table">
                <div class="cell">
                    <input type="button" value="S" class="search">
                    <input type="text" placeholder="Поиск по клиентам" class="clients_name">
                </div>
                <div class="cell row-second">
                    Сортировать по:
                    <span class="sort_last_order">Последний заказ</span>
                    Заказов от: <input type="text" class="last_order_from">
                    Заказов до: <input type="text" class="last_order_to">
                </div>
            </div>
        </div>
        <?php Pjax::begin(['enablePushState' => false, 'enableReplaceState' => false, 'timeout'=>6000, 'id' => 'gridpjax']); ?>
        <?= GridView::widget([
            'layout' => '{summary}{pager}{items}{pager}',
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last'
            ],
            'summary'=>'',
            //'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-hover'],
            //'headerRowOptions' => ['class'=>'x'],
            'rowOptions' => function ($model, $index, $widget, $grid){
                return ['clienttype'=>$model->status];
            },
            'columns' => [

                [
                    "class" => yii\grid\DataColumn::className(),
                    "attribute" => "fio",
                    "value" => function($model){
                        return \yii\helpers\html::tag('div', $model->fio, ['class' => 'fio']);
                    },
                    "format" => "raw",
                ],

                [
                    "class" => yii\grid\DataColumn::className(),
                    'contentOptions' => ['class' => 'lastordercell'],
                    "attribute" => "last_order",
                    "value" => function($model){
                        $lastorder = $model->getLastOrder();
                        return \yii\helpers\html::tag('div', "№ " . $lastorder['id'], [ 'class' => 'number' ])
                                . \yii\helpers\html::tag('div', \common\components\helpers\DateTimeHelper::getDisplayDateTime($lastorder['created_at']))
                                . \yii\helpers\html::tag('div', Yii::$app->formatter->asCurrency($lastorder['summ']), [ 'class' => 'currency' ]);
                    },
                    "format" => "raw",
                ],

                [
                    "class" => yii\grid\DataColumn::className(),
                    "attribute" => "orders_count",
                    "value" => function($model){
                        //return \yii\helpers\html::tag('div', $model->getOrdersCount(), ['class' => 'orderscount']);
                        //return \yii\helpers\html::tag('div', $model->count, ['class' => 'orderscount']);
                        return \yii\helpers\html::tag('div', $model->orderCount, ['class' => 'orderscount']);
                    },
                    "format" => "raw",
                ],

                [
                    "class" => yii\grid\DataColumn::className(),
                    "attribute" => "orders_summ",
                    "value" => function($model){
                        //return \yii\helpers\html::tag('div', Yii::$app->formatter->asCurrency($model->getOrdersSumm()), [ 'class' => 'currency' ]);
                        //return \yii\helpers\html::tag('div', Yii::$app->formatter->asCurrency($model->sum), [ 'class' => 'currency' ]);
                        return \yii\helpers\html::tag('div', Yii::$app->formatter->asCurrency($model->orderAmount), [ 'class' => 'currency' ]);

                    },
                    "format" => "raw",
                ],

                [
                    "class" => yii\grid\DataColumn::className(),
                    "attribute" => "status",
                    "value" => function($model){
                        return $model->getStatus($model->status);
                    },
                    "format" => "raw",
                ],

                [
                    "class" => yii\grid\DataColumn::className(),
                    "attribute" => "register_at",
                    "value" => function($model){
                        return \common\components\helpers\DateTimeHelper::getDisplayDateTime($model->register_at);
                    },
                    "format" => "raw",
                ],

            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>

</div>
