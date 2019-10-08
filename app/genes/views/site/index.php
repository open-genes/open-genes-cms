<?php
/**
 * @var $genes array
 * @var $latestGenesDtos array
 */

use genes\widgets\LatestGenesWidget;

?>

<div class="col col-16">
    <section class="view-latest">
        <div class="page__subtitle view-latest__title">
            <?= Yii::t('main', 'main_page_last_edited'); ?>
        </div>
        <div class="view-latest__content">
            <?= LatestGenesWidget::widget(['geneDtos' => $latestGenesDtos]) ?>
        </div>
    </section>
</div>

<div class="view-panel col col-16">
    <div class="page__subtitle per per-70 __middle">
        <?= Yii::t('main', 'main_page_total') ?> <?= count($genes) - 1 ?>
    </div>
    <div class="view-panel__buttons per per-30 __middle">
        <button class="toggler toggler--def js_toggler js_view-toggler">
            <span class="fa far fa-table toggler__icon toggler__icon--def"></span>
            <span class="fa far fa-th-large toggler__icon toggler__icon--alt"></span>
        </button>
    </div>
</div>


<div class="col col-16">
    <section class="view-content view-content--as-table js_items-section">
        <div class="thead thead--fixed" id="js_items-section__categories">
            <div class="th">
                <div class="th__title">
                    <b><?= Yii::t('main', 'main_page_table_name') ?></b>
                </div>
            </div>

            <div class="th th--wider th-age js_sort-by-age-btn">
                <div class="th__title">
                    <b><?= Yii::t('main', 'phylogeny') ?></b>
                </div>
            </div>

            <div class="th th--wide">
                <div class="th__title">
                    <b><?= Yii::t('main', 'age') ?></b> (<?= Yii::t('main', 'million_years') ?>)
                </div>
            </div>

            <? /*
                        <div class="th th--wide">
                            <div class="th__title">
                                <b>Обоснованность</b>
                            </div>
                        </div>
                        */ ?>

            <div class="th th--wide">
                <div class="th__title">
                    <b><?= Yii::t('main', 'main_page_table_functional_clusters') ?></b>
                </div>
            </div>

            <div class="th th--wide">
                <div class="th__title">
                    <b><?= Yii::t('main', 'diseases') ?></b>
                </div>
            </div>

            <div class="th th--wide">
                <div class="th__title">
                    <b><?= Yii::t('main', 'main_page_table_interactions') ?></b>
                </div>
            </div>
        </div>

        <div class="tbody" id="js_items-section__content">
            <? foreach ($genes as $gene): ?>

                <?
                if ($gene['ageMya'] == '') {
                    $dataAge = 0;
                } else {
                    $dataAge = $gene['ageMya'];
                }
                ?>

                <div class="tr js_table__gene"
                     data-age="<?= $dataAge ?>"
                     data-hagr="<?= $gene['ID']; ?>"
                >

                    <div class="td td-name">
                        <div class="td__title">
                            <a href="gene?gene=<?= $gene['ID'] ?>"
                               class="link">
                                <b>
                                    <?= $gene['symbol'] ?>
                                </b>
                                <?= $gene['name'] ?>
                            </a>

                            <a href="https://genomics.senescence.info/genes/entry.php?hgnc=<?= $gene['symbol'] ?>"
                               target="_blank"
                               title="<?= Yii::t('main', 'link_geneage') ?>"
                               class="tag tag--small"><?= $gene['ID']; ?></a>
                        </div>
                    </div>

                    <div class="td td-age-phylo <?=  '' /* todo ? $ifAgePhyloEmpty */  ?>">
                        <span class="td__label"><?= Yii::t('main', 'age') ?>: </span>
                        <b><?= $gene['agePhylo'] ?></b>
                    </div>

                    <div class="td td-age-mya">
                        <? if ($gene['ageMya']): ?>
                            <?= $gene['ageMya'] ?> <span class="td__unit"><?= Yii::t('main', 'million_years') ?></span>
                        <? else: ?>
                            <?= Yii::t('main', 'age_unknown') ?>
                        <? endif ?>
                    </div>

                    <div class="td td--text-left td-clusters">
                        <? if ($gene['functionalClusters']): ?>
                            <span class="td__label"><?= Yii::t('main', 'main_page_table_functional_clusters') ?></span>
                            <?
//                            $genesFunctions = new Gene();
                            $functionalClusters = $gene['functionalClusters'];
                            $functionalClustersArray = explode(',', $functionalClusters); //$genesFunctions->comma_separated_to_array($functionalClusters);
                            ?>
                            <? foreach ($functionalClustersArray as $functionalCluster): ?>
                                <?
                                // SQL keys come already in Russian, giving them a key-like look:
                                // // TODO: Это временный костыль
                                $functionalCluster = preg_replace('/\s+/', '_', $functionalCluster);
                                $functionalCluster = preg_replace('/^_/', '', $functionalCluster);
                                $functionalCluster = preg_replace('/[\/]/', '_', $functionalCluster);
                                ?>
                                <a href=""
                                   class="tag"
                                ><?= Yii::t('main', $functionalCluster) ?></a>
                            <? endforeach; ?>
                        <? endif; ?>
                    </div>

                    <div class="td td--text-right td-external">
                        <a href="http://disgenet.org/browser/1/1/0/<?= $gene['entrezGene'] ?>/"
                           target="_blank"
                           title="<?= Yii::t('main', 'link_disgenet') ?>"
                           class="badge badge--disgenet"
                        >
                            DisGenet</a>
                    </div>

                    <div class="td td--text-right td-external">
                        <a href="https://thebiogrid.org/search.php?search=<?= $gene['symbol'] ?>&organism=9606/"
                           target="_blank"
                           title="<?= Yii::t('main', 'link_biogrid') ?>"
                           class="badge badge--biogrid"
                        >
                            BioGrid</a>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </section>
</div>