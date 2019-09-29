<? include $_SERVER['DOCUMENT_ROOT'] . '/contollers/core.php'; ?>
<!DOCTYPE html >
<html>
<?
include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/head.inc.php';
html_headChunk('Aging Related Genes Base');
?>

<body>

<? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/loader.inc.php'; ?>

<? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/header.inc.php'; ?>

<div class="page main-page">
    <div class="page__inner">
        <div class="wrapper main-page__header">
            <div class="container">
                <div class="col col-16">
                    <div class="page__title">
                        <h1>
                            <?= $translation->translate('main_page_header_title') ?>
                        </h1>
                    </div>
                    <div class="header__description">
                        <?= $translation->translate('main_page_header_description') ?>
                    </div>
                    <div class="header__button">
                        <a href="/about"
                           class="btn btn-purple btn-flat js_link"
                        >
                            <?= $translation->translate('main_page_header_button') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col col-16">
                <?
                $sql = 'SELECT `ID`, `dateAdded`, `symbol`, `agePhylo`, `ageMya` FROM `' . $database . '`.`' . $table . '`' . ' ORDER BY `functionalClusters` DESC, `dateAdded` ASC, `ageMya` DESC LIMIT 4;';
                $request = $pdo->prepare($sql);
                $request->execute();
                ?>

                <section class="view-latest">
                    <div class="page__subtitle view-latest__title">
                        <?= $translation->translate('main_page_last_edited') ?>
                    </div>
                    <div class="view-latest__content">
                        <? while ($gene = $request->fetch(PDO::FETCH_ASSOC)): ?>
                            <a href="gene/?gene=<?= $gene['ID'] ?>"
                               class="view-latest__card">
                                <div class="card__inner">
                                    <div class="card__title">
                                        <?= $gene['symbol'] ?>
                                    </div>
                                    <? if ($gene['agePhylo']): ?>
                                        <div class="card__phylo">
                                            <?= $gene['agePhylo'] ?>
                                        </div>
                                    <? endif; ?>
                                    <? if ($gene['ageMya']): ?>
                                        <div class="card__mya">
                                            <?= $gene['ageMya'] ?>  <?= $translation->translate('million_years') ?>
                                        </div>
                                    <? endif; ?>
                                </div>
                            </a>
                        <? endwhile; ?>
                    </div>
                </section>
            </div>

            <div class="view-panel col col-16">
                <div class="page__subtitle per per-70 __middle">
                     <?= $translation->translate('main_page_total') ?> <?= count($_SESSION['sortedGenesData']) - 1 ?>
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
                                <b><?= $translation->translate('main_page_table_name') ?></b>
                            </div>
                        </div>

                        <div class="th th--wider th-age js_sort-by-age-btn">
                            <div class="th__title">
                                <b><?= $translation->translate('age') ?></b> <?= $translation->translate('main_page_table_phylogeny') ?>
                            </div>
                        </div>

                        <div class="th th--wide">
                            <div class="th__title">
                                <b><?= $translation->translate('age') ?></b> (<?= $translation->translate('million_years') ?>)
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
                                <b><?= $translation->translate('main_page_table_functional_clusters') ?></b>
                            </div>
                        </div>

                        <div class="th th--wide">
                            <div class="th__title">
                                <b><?= $translation->translate('main_page_table_diseases') ?></b>
                            </div>
                        </div>

                        <div class="th th--wide">
                            <div class="th__title">
                                <b><?= $translation->translate('main_page_table_interactions') ?></b>
                            </div>
                        </div>
                    </div>

                    <div class="tbody" id="js_items-section__content">
                        <? foreach ($_SESSION['sortedGenesData'] as $gene): ?>

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
                                           title="Ген на GeneAge"
                                           class="tag tag--small"><?= $gene['ID']; ?></a>
                                    </div>
                                </div>

                                <div class="td td-age-phylo <?= $ifAgePhyloEmpty ?>">
                                    <span class="td__label"><?= $translation->translate('age') ?>: </span>
                                    <b><?= $gene['agePhylo'] ?></b>
                                </div>

                                <div class="td td-age-mya">
                                <? if ($gene['ageMya']): ?>
                                    <?= $gene['ageMya'] ?> <span class="td__unit"><?= $translation->translate('million_years') ?></span>
                                <? else: ?>
                                    <?= $translation->translate('age_unknown') ?>
                                <? endif ?>
                                </div>

                                <? /*
                                <div class="td td--text-left">
                                    <? if ($gene['rating']): ?>
                                        <a href="gene?gene=<?= $gene['ID'] ?>"
                                           class="rating<? if ($gene['rating'] > 5): ?> rating--medium<? else: ?> rating--high<? endif; ?>">
                                            <?= $gene['rating'] ?>
                                        </a>
                                    <? endif; ?>
                                </div>
                                */ ?>

                                <div class="td td--text-left td-clusters">
                                    <? if ($gene['functionalClusters']): ?>
                                        <span class="td__label"><?= $translation->translate('main_page_table_functional_clusters') ?></span>
                                        <?
                                        $genesFunctions = new Gene();
                                        $functionalClusters = $gene['functionalClusters'];
                                        $functionalClustersArray = $genesFunctions->comma_separated_to_array($functionalClusters);
                                        ?>
                                        <? foreach ($functionalClustersArray as $functionalCluster): ?>
                                            <?
                                            // SQL keys come already in Russian, giving them a key-like look:
                                            $functionalCluster = preg_replace('/\s+/', '_', $functionalCluster);
                                            $functionalCluster = preg_replace('/^_/', '', $functionalCluster);
                                            $functionalCluster = preg_replace('/[\/]/', '_', $functionalCluster);
                                            ?>
                                            <a href=""
                                               class="tag"
                                            ><?= $translation->translate($functionalCluster) ?></a>
                                        <? endforeach; ?>
                                    <? endif; ?>
                                </div>

                                <div class="td td--text-right td-external">
                                    <a href="http://disgenet.org/browser/1/1/0/<?= $gene['entrezGene'] ?>/"
                                       target="_blank"
                                       title="<?= $translation->translate('main_page_table_link_uniprot') ?>"
                                       class="badge badge--disgenet"
                                    >
                                        DisGenet</a>
                                </div>

                                <div class="td td--text-right td-external">
                                    <a href="https://thebiogrid.org/search.php?search=<?= $gene['symbol'] ?>&organism=9606/"
                                       target="_blank"
                                       title="<?= $translation->translate('main_page_table_link_biogrid') ?>"
                                       class="badge badge--biogrid"
                                    >
                                        BioGrid</a>
                                </div>
                            </div>
                        <? endforeach; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/footer.inc.php'; ?>

</body>
</html>
