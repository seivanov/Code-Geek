<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="table-responsive">
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
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class'=>'x'],
            'columns' => [

                'fio',

                [
                    "class" => yii\grid\DataColumn::className(),
                    "attribute" => "last_order",
                    "value" => function($model){
                        $lastorder = $model->getLastOrder();
                        return "№ " . $lastorder['id'] . ' ' . date('d-m-Y', $lastorder['created_at']) . ' ' . $lastorder['summ'] . 'р';
                    },
                    "format" => "raw",
                ],

                [
                    "class" => yii\grid\DataColumn::className(),
                    "attribute" => "orders_count",
                    "value" => function($model){
                        return $model->getOrdersCount();
                    },
                    "format" => "raw",
                ],

                [
                    "class" => yii\grid\DataColumn::className(),
                    "attribute" => "orders_summ",
                    "value" => function($model){
                        return $model->getOrdersSumm();
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
                        return date('d-m-Y', $model->register_at);
                    },
                    "format" => "raw",
                ],

            ],
        ]); ?>
    </div>

</div>
