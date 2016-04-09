<?php
/** @var $this SiteController */
/** @var $dataProvider CActiveDataProvider|CSqlDataProvider */

/** @var $clientScript CClientScript */
$clientScript = Yii::app()->clientScript;
$clientScript->registerCss(
    'pager',
    'ul.yiiPager .first, ul.yiiPager .last {display:inline !important;}'
);

$this->pageTitle = Yii::app()->name;
?>
<div class="row">
    <?php if ($dataProvider instanceof CActiveDataProvider): ?>
        <h2>Решение с помощью AR-модели</h2>
    <?php else: ?>
        <h2>Решение с помощью DAO</h2>
    <?php endif; ?>

    <?php $this->widget('zii.widgets.grid.CGridView', [
        'dataProvider' => $dataProvider,
        'enableHistory' => true,
        //'ajaxUpdate'=>false,
        'columns' => [
            'cx:text:CX',
            'rx:text:RX',
            'title:text:Title',
            'ndc:text:NDC',
        ]
    ]); ?>
</div>