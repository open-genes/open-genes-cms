<?php
/** @var $geneDtos \genes\application\dto\GeneViewDto[] */
?>
<div class="col col-16">
    <section class="view-latest">
        <div class="page__subtitle view-latest__title">
            <?= Yii::t('main', 'main_page_last_edited'); ?>
        </div>
        <div class="view-latest__content">
            <? foreach ($geneDtos as $geneDto): ?>
                <a href="gene/?gene=<?= $geneDto->id ?>" class="view-latest__card">
                    <div class="card__inner">
                        <div class="card__title"><?= $geneDto->symbol; ?></div>
                        <div class="card__phylo"><?= $geneDto->agePhylo; ?></div>
                        <div class="card__mya"><?= $geneDto->ageMya; ?> <?= Yii::t('main', 'million_years') ?></div>
                    </div>
                </a>
            <? endforeach; ?>
        </div>
    </section>
</div>
