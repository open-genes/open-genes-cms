<?php

use yii\data\ActiveDataProvider;

/**
 * @var $dataProvider ActiveDataProvider
 */
?>
<!--<meta http-equiv="refresh" content="0;URL=/redirect.php">-->
<div class="page gene-page">
    <div class="page__inner">
        <section class="wrapper gene-page__header">
            <div class="container">
                <div class="col col-16 header__short-comment">
                </div>
            </div>
        </section>

        <section class="wrapper gene-page__age">
            <?= \yii\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'name',
                    'aliases',
                    'agePhylo',
//                    'created_at:datetime',
                    // ...
                ],
            ]) ?>
        </section>
    </div>
</div>