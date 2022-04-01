<?php

use \yii\grid\GridView;

/** @var yii\web\View $this */

$this->title = '厂商列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,//数据提供器
    'filterModel'  => $searchModel,//搜索功能
    'columns'      => [//列数据
        [
            //显示复选框
            'class'         => 'yii\grid\CheckboxColumn',
            //整行footer
            'footerOptions' => ['colspan' => 5],
            'footer'        => '<a class="btn btn-primary" href="' . \Yii::$app->urlManager->createUrl(['supplier/export-page', 'condition' => $condition]) . '">导出全部结果</a>',
        ],

        [
            'attribute'     => 'id',
            'footerOptions' => ['style' => 'display: none'],
        ],
        [
            'attribute'     => 'name',
            'footerOptions' => ['style' => 'display: none'],
        ],
        [
            'attribute'     => 'code',
            'footerOptions' => ['style' => 'display: none'],
        ],
        [
            'attribute'     => 't_status',
            'filter'        => [
                'ok'   => 'Ok',
                'hold' => 'Hold',
            ],
            'footerOptions' => ['style' => 'display: none'],
        ],
    ],
    //整体布局
    'layout'       => "{items}\n{pager}",
    //显示表格尾部
    'showFooter'   => true,
    //页码样式
    'pager'        => [
        'linkContainerOptions'          => [
            'class' => 'page-item',
        ],
        'linkOptions'                   => [
            'class' => 'page-link',
        ],
        'disabledListItemSubTagOptions' => [
            'tag'      => 'a',
            'href'     => 'javascript:;',
            'tabindex' => '-1',
            'class'    => 'page-link',
        ],
        'firstPageLabel'                => '首页',
        'prevPageLabel'                 => '上一页',
        'nextPageLabel'                 => '下一页',
        'lastPageLabel'                 => '尾页',
    ],
    //数据为空文案
    'emptyText'    => '数据暂时为空！',
]);
?>
