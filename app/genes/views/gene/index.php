<?php

use genes\application\dto\GeneViewDto;
/**
 * @var $gene GeneViewDto
 */
?>
<!--<meta http-equiv="refresh" content="0;URL=/redirect.php">-->
<!-- todo another body class -->
<div class="page gene-page">
    <div class="page__inner">
        <section class="wrapper gene-page__header">
            <div class="container">
                <div class="col col-16 header__title">
                    <div class="title__caption">
                        <div class="caption__inner">
                            <?= $gene->symbol; ?>
                        </div>
                    </div>
                    <div class="title__vendors">
                        <a href="https://genomics.senescence.info/genes/entry.php?hgnc=<?= $gene->symbol; ?>"
                           target="_blank"
                           title="<?= Yii::t('main', 'link_geneage'); ?>"
                           class="badge badge--geneage"
                        >GeneAge</a>

                        <a href="https://www.ncbi.nlm.nih.gov/gene/<?= $gene->entrezGene; ?>"
                           target="_blank"
                           title="<?= Yii::t('main', 'link_entrez') ?>"
                           class="badge badge--entrez"
                        >EntrezGene</a>

                        <a href="https://www.uniprot.org/uniprot/<?= $gene->uniprot; ?>"
                           target="_blank"
                           title="<?= Yii::t('main', 'link_uniprot') ?>"
                           class="badge badge--uniprot"
                        >UniProt</a>
                    </div>
                </div>
                <div class="col col-16 header__short-comment">
                              <span class="str_source-GeneAge">
                                <?= $gene->name; ?>
                              </span>
                </div>
                <div class="col col-16 header__functional-clusters">
                    <? if ($gene->functionalClusters): ?>
                        <? foreach ($gene->functionalClusters as $functionalCluster): ?>
                            <a href="" class="tag"><?= $functionalCluster; ?></a>
                        <? endforeach; ?>
                    <? else: ?>
                        <span class="tag __skeletal"></span>
                        <span class="tag __skeletal"></span>
                        <span class="tag __skeletal"></span>
                        <span class="tag __skeletal"></span>
                    <? endif; ?>
                </div>
            </div>
        </section>

        <section class="wrapper gene-page__age">
            <div class="container">
                <div class="col col-16 page__title">
                    <h1><?= Yii::t('main', 'age') ?></h1>
                </div>
            </div>
            <div class="container __flex age__types">
                <div class="col col-4 __preserve-width __flex-auto age__type">
                    <div class="type__title">
                        <?= Yii::t('main', 'phylogeny') ?>
                    </div>
                    <div class="type__value">
                        <? if ($gene->agePhylo): ?>
                            <?= $gene->agePhylo ?>
                        <? else: ?>
                            <?= Yii::t('main', 'gene_page_origin_unknown') ?>
                        <? endif; ?>
                    </div>
                </div>

                <div class="col col-4 __preserve-width __flex-auto age__type">
                    <div class="type__title">
                        <?= Yii::t('main', 'age') ?>
                    </div>
                    <div class="type__value">
                        <? if ($gene->ageMya): ?>
                            <?= $gene->ageMya ?>
                            <small><?= Yii::t('main', 'million_years') ?></small>
                        <? else: ?>
                            <?= Yii::t('main', 'gene_page_age_unknown') ?>
                        <? endif; ?>
                    </div>
                </div>

                <a href="http://disgenet.org/browser/1/1/0/<?= $gene->entrezGene ?>/"
                   target="_blank"
                   title="<?= Yii::t('main', 'gene_page_link_disgenet') ?>" class="col col-3 __preserve-width __flex-auto age__type age__diseases">
                    <div class="type__title">
                        <?= Yii::t('main', 'diseases') ?>
                    </div>
                    <div class="type__value">
                                    <span class="badge badge--disgenet">
                                        <span class="fa fal fa-stream"></span>
                                        <?= Yii::t('main', 'gene_page_link_disgenet') ?>
                                    </span>
                    </div>
                </a>

                <a href="https://thebiogrid.org/search.php?search=<?= $gene->symbol ?>&organism=9606/"
                   target="_blank"
                   title="<?= Yii::t('main', 'gene_page_link_biogrid') ?>"
                   class="col col-3 __preserve-width __flex-auto age__type age__interactions">
                    <div class="type__title">
                        <?= Yii::t('main', 'gene_page_title_interactions') ?>
                    </div>
                    <div class="type__value">
                                    <span class="badge badge--biogrid">
                                        <span class="fa fal fa-search"></span>
                                        <?= Yii::t('main', 'gene_page_link_biogrid') ?>
                                    </span>
                    </div>
                </a>

                <? if ($gene->rating): ?>
                    <? // Temporarily not in use until genetics will develop criteria  ?>
                    <div class="col col-7 __preserve-width __flex-auto age__type age__rating">
                        <div class="type__title">
                            <?= Yii::t('main', 'gene_page_title_criteria') ?>
                            <small><sup>*</sup></small>
                        </div>
                        <div class="type__value">
                            <span
                                class="rating<? if ($gene->rating > 5): ?> rating--medium<? else: ?> rating--high<? endif; ?>">
                                <?= $gene->rating; ?>
                            </span>
                        </div>
                        <div class="type__description">
                            <?= $gene->rating; ?>
                        </div>
                    </div>
                <? endif; ?>
            </div>
        </section>

        <div class="wrapper gene-page__articles">
            <div class="container">
                <div class="col col-16 page__title">
                    <h1><?= Yii::t('main', 'gene_page_title_description') ?></h1>
                </div>
                <? if ($gene->aliases): ?>
                    <div class="col col-16 articles__content">
                        <h3><?= Yii::t('main', 'gebe_page_title_aliases') ?></h3>
                        <? foreach ($gene->aliases as $geneAlias): ?>
                            <a href="" class="tag"><?= $geneAlias ?></a>
                        <? endforeach; ?>
                    </div>
                <? endif; ?>

                <? if ($gene->commentEvolution || $gene->commentFunction || $gene->commentCause || $gene->commentAging || $gene->commentsReferenceLinks): ?>
                    <div class="col col-16 articles__content">
                        <h3><?= Yii::t('main', 'gene_page_title_contents') ?></h3>

                        <ul class="list contents-list">
                            <? if ($gene->commentEvolution): ?>
                                <li>
                                    <a href="#evolution">
                                        <?= Yii::t('main', 'gene_page_title_evolution') ?>
                                    </a>
                                </li>
                            <? endif; ?>
                            <? if ($gene->commentFunction): ?>
                                <li>
                                    <a href="#function">
                                        <?= Yii::t('main', 'gene_page_title_function') ?>
                                    </a>
                                </li>
                            <? endif; ?>
                            <? if ($gene->commentCause): ?>
                                <li>
                                    <a href="#cause">
                                        <?= Yii::t('main', 'gene_page_title_criteria') ?>
                                    </a>
                                </li>
                            <? endif; ?>
                            <? if ($gene->commentAging): ?>
                                <li>
                                    <a href="#aging">
                                        <?= Yii::t('main', 'gene_page_title_aging') ?>
                                    </a>
                                </li>
                            <? endif; ?>
                            <? if ($gene->commentsReferenceLinks): ?>
                                <li>
                                    <a href="#reference">
                                        <?= Yii::t('main', 'gene_page_title_reference') ?>
                                    </a>
                                </li>
                            <? endif; ?>
                        </ul>

                        <? if ($gene->commentEvolution): ?>
                            <h3><?= Yii::t('main', 'gene_page_title_evolution') ?></h3>

                            <article id="evolution">
                                <?= $gene->commentEvolution ?>
                            </article>
                        <? endif; ?>

                        <? if ($gene->commentFunction): ?>
                            <h3><?= Yii::t('main', 'gene_page_title_function') ?></h3>
                            <article id="function">
                                <?= $gene->commentFunction ?>
                            </article>
                        <? endif; ?>

                        <? if ($gene->commentCause): ?>
                            <h3><?= Yii::t('main', 'gene_page_title_criteria') ?></h3>
                            <article id="cause">
                                <ul class="list list--bulletted">
                                    <? foreach ($gene->commentCause as $commentsCauseItem): ?>
                                        <li><?= $commentsCauseItem; ?></li>
                                    <? endforeach; ?>
                                </ul>
                            </article>
                        <? endif; ?>

                        <? if ($gene->commentAging): ?>
                            <h3><?= Yii::t('main', 'gene_page_title_aging') ?></h3>
                            <article id="aging">
                                <?= $gene->commentAging ?>
                            </article>
                        <? endif; ?>

                        <? if ($gene->commentsReferenceLinks): ?>
                            <article id="reference" class="js_article-reference">
                                <ul class="list reference-list">
                                    <? if ($gene->commentsReferenceLinks): ?>
                                        <? foreach ($gene->commentsReferenceLinks as $commentsRefLink => $commentsRef): ?>
                                            <li>
                                                <a href="https://doi.org/<?= $commentsRefLink ?>"
                                                   target="_blank"
                                                   class="reference-link"><?= $commentsRef ?></a>
                                            </li>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                </ul>
                            </article>
                        <? endif; ?>
                    </div>
                <? else: ?>
                    <section class="col col-16 no-content">
                        <div class="no-content__icon no-content__icon-standard"></div>
                        <div class="no-content__title">
                            <div class="title__center">
                                <?= Yii::t('main', 'gene_page_error_no_article_yet') ?>
                            </div>
                        </div>
                    </section>
                <? endif; ?>
            </div>
        </div>

        <? if ($gene->expression): ?>
            <section class="wrapper gene-page__expression">
                <div class="container">
                    <div class="col col-16 page__title">
                        <h1><?= Yii::t('main', 'gene_page_title_expression') ?></h1>
                        <p>
                            <?= Yii::t('main', 'gene_page_expression_hint') ?>
                        </p>
                    </div>

                    <div class="col col-16 expression__rows">
                        <?
                        foreach ($gene->expression as $expression) {
                            echo
                                '<div class="expression__row">' .
                                '<div class="row__name">' . ucfirst($expression['name']) . '</div>' .

                                '<div class="row__value ' . ($expression['exp_rpkm'] < 2 ? 'row__value--minimum' : '') . '">' .
                                '<div class ="value__bar" ' . 'style="width: ' . $expression['exp_rpkm'] * 2 . '%"></div>' .

                                '<div class ="value__rpkm">' .
                                $expression['exp_rpkm'] . ' RPKM' .
                                '</div>' .
                                '</div>' .
                                '</div>';
                        }
                        ?>
                    </div>
                </div>
            </section>
        <? endif; ?>
    </div>
</div>