<? include $_SERVER['DOCUMENT_ROOT'] . '/contollers/core.php'; ?>
<? if (!isset($_GET['gene']) || empty($_GET['gene'])): ?>
    <? echo '<meta http-equiv="refresh" content="0;URL=/redirect.php">' ?>
    <? $genePage = array(); ?>
<? else: ?>
    <? foreach ($_SESSION['allGenesData'] as $gene): ?>
        <? $genePageBaseID = intval($gene['ID']); ?>
        <? $genePageRouteID = intval($_GET['gene']); ?>
        <? if ($genePageBaseID == $genePageRouteID): ?>
            <?
            include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/head.inc.php';
            html_headChunk($gene['symbol'] . ' ' . $gene['name']);
            ?>

            <body class="app-body app-body--gene">

            <? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/loader.inc.php'; ?>

            <? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/header.inc.php'; ?>

            <?
            $postfix = '';
            if ($_SESSION['$current_locale'] == 'en') {
                $postfix = 'EN';
            }

            $commentEvolution = 'commentEvolution' . $postfix;
            $commentFunction = 'commentFunction' . $postfix;
            $commentAging = 'commentAging' . $postfix;
            $expression = 'expression' . $postfix;
            $gene[$expression] = isset($gene[$expression]) && !empty($gene[$expression]) ? json_decode($gene[$expression], true) : null;
            ?>

            <div class="page gene-page">
                <div class="page__inner">
                    <section class="wrapper gene-page__header">
                        <div class="container">
                            <div class="col col-16 header__title">
                                <div class="title__caption">
                                    <div class="caption__inner">
                                        <?= $gene['symbol'] ?>
                                    </div>
                                </div>
                                <div class="title__vendors">
                                    <a href="https://genomics.senescence.info/genes/entry.php?hgnc=<?= $gene['symbol'] ?>"
                                       target="_blank"
                                       title="<?= $translation->translate('link_geneage') ?>"
                                       class="badge badge--geneage"
                                    >GeneAge</a>

                                    <a href="https://www.ncbi.nlm.nih.gov/gene/<?= $gene['entrezGene'] ?>"
                                       target="_blank"
                                       title="<?= $translation->translate('link_entrez') ?>"
                                       class="badge badge--entrez"
                                    >EntrezGene</a>

                                    <a href="https://www.uniprot.org/uniprot/<?= $gene['uniprot'] ?>"
                                       target="_blank"
                                       title="<?= $translation->translate('link_uniprot') ?>"
                                       class="badge badge--uniprot"
                                    >UniProt</a>
                                </div>
                            </div>
                            <div class="col col-16 header__short-comment">
                              <span class="str_source-GeneAge">
                                <?= $gene['name'] ?>
                              </span>
                            </div>
                            <div class="col col-16 header__functional-clusters">
                                <?
                                $geneFunctions = new Gene();
                                $functionalClusters = $gene['functionalClusters'];
                                $functionalClustersArray = $geneFunctions->comma_separated_to_array($functionalClusters);
                                ?>
                                <? if ($functionalClusters): ?>
                                    <? foreach ($functionalClustersArray as $functionalCluster): ?>
                                        <?
                                        // SQL keys come already in Russian, giving them a key-like look:
                                        // // TODO: Это временный костыль
                                        // TODO: preg_replace is deprecated in PHP7.1!
                                        $functionalCluster = preg_replace('/\s+/', '_', $functionalCluster);
                                        $functionalCluster = preg_replace('/^_/', '', $functionalCluster);
                                        $functionalCluster = preg_replace('/[\/]/', '_', $functionalCluster);
                                        ?>
                                        <a href=""
                                           class="tag"
                                        ><?= $translation->translate($functionalCluster) ?></a>
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
                                <h1><?= $translation->translate('age') ?></h1>
                            </div>
                        </div>
                        <div class="container __flex age__types">
                            <div class="col col-4 __preserve-width __flex-auto age__type">
                                <div class="type__title">
                                    <?= $translation->translate('phylogeny') ?>
                                </div>
                                <div class="type__value">
                                    <? if ($gene['agePhylo']): ?>
                                        <?= $gene['agePhylo'] ?>
                                    <? else: ?>
                                        <?= $translation->translate('unknown') ?>
                                    <? endif; ?>
                                </div>
                            </div>

                            <div class="col col-4 __preserve-width __flex-auto age__type">
                                <div class="type__title">
                                    <?= $translation->translate('age') ?>
                                </div>
                                <div class="type__value">
                                    <? if ($gene['ageMya']): ?>
                                        <?= $gene['ageMya'] ?>
                                        <small><?= $translation->translate('million_years') ?></small>
                                    <? else: ?>
                                        <?= $translation->translate('unknown') ?>
                                    <? endif; ?>
                                </div>
                            </div>

                            <a href="http://disgenet.org/browser/1/1/0/<?= $gene['entrezGene'] ?>/"
                               target="_blank"
                               title="<?= $translation->translate('gene_page_link_disgenet') ?>" class="col col-3 __preserve-width __flex-auto age__type age__diseases">
                                <div class="type__title">
                                    <?= $translation->translate('diseases') ?>
                                </div>
                                <div class="type__value">
                                    <span class="badge badge--disgenet">
                                        <span class="fa fal fa-stream"></span>
                                        <?= $translation->translate('gene_page_link_disgenet') ?>
                                    </span>
                                </div>
                            </a>

                            <a href="https://thebiogrid.org/search.php?search=<?= $gene['symbol'] ?>&organism=9606/"
                               target="_blank"
                               title="<?= $translation->translate('gene_page_link_biogrid') ?>"
                               class="col col-3 __preserve-width __flex-auto age__type age__interactions">
                                <div class="type__title">
                                    <?= $translation->translate('gene_page_title_interactions') ?>
                                </div>
                                <div class="type__value">
                                    <span class="badge badge--biogrid">
                                        <span class="fa fal fa-search"></span>
                                        <?= $translation->translate('gene_page_link_biogrid') ?>
                                    </span>
                                </div>
                            </a>

                            <? if ($gene['rating']): ?>
                            <? // Temporarily not in use until genetics will develop criteria  ?>
                                <div class="col col-7 __preserve-width __flex-auto age__type age__rating">
                                    <div class="type__title">
                                        <?= $translation->translate('gene_page_title_criteria') ?>
                                        <small><sup>*</sup></small>
                                    </div>
                                    <div class="type__value">
                                        <span
                                            class="rating<? if ($gene['rating'] > 5): ?> rating--medium<? else: ?> rating--high<? endif; ?>">
                                            <?= $gene['rating'] ?>
                                        </span>
                                    </div>
                                    <div class="type__description">
                                        <?
                                        $ratingDetails = new Gene();
                                        echo $ratingDetails->gene_rating_details($gene['rating']);
                                        ?>
                                    </div>
                                </div>
                            <? endif; ?>
                        </div>
                    </section>


                    <div class="wrapper gene-page__articles">
                        <div class="container">
                            <div class="col col-16 page__title">
                                <h1><?= $translation->translate('gene_page_title_description') ?></h1>
                            </div>

                            <?
                            $geneSynonyms = new Gene();
                            $geneAliases = $gene['aliases'];
                            $geneAliasesArray = $geneSynonyms->space_separated_to_array($geneAliases);

                            if ($_SESSION['$current_locale'] == 'en') {
                                $postfix = 'En';
                            } else {
                                $postfix = '';
                            }
                            ?>
                            <? if ($geneAliases): ?>
                                <div class="col col-16 articles__content">
                                    <h3><?= $translation->translate('gebe_page_title_aliases') ?></h3>

                                    <? foreach ($geneAliasesArray as $geneAlias): ?>
                                        <a href=""
                                           class="tag"
                                        ><?= $geneAlias ?></a>
                                    <? endforeach; ?>
                                </div>
                            <? endif; ?>

                            <? if ($gene[$commentEvolution] || $gene[$commentFunction] || $gene['commentCause'] || $gene[$commentAging] || $gene['commentsReferenceLinks'] || $gene[$expression]): ?>
                                <div class="col col-16 articles__content">
                                    <h3><?= $translation->translate('gene_page_title_contents') ?></h3>

                                    <ul class="list contents-list">
                                        <? if ($gene[$commentEvolution]): ?>
                                            <li>
                                                <a href="#evolution">
                                                    <?= $translation->translate('gene_page_title_evolution') ?>
                                                </a>
                                            </li>
                                        <? endif; ?>
                                        <? if ($gene[$commentFunction]): ?>
                                            <li>
                                                <a href="#function">
                                                    <?= $translation->translate('gene_page_title_function') ?>
                                                </a>
                                            </li>
                                        <? endif; ?>
                                        <? if ($gene['commentCause']): ?>
                                            <li>
                                                <a href="#cause">
                                                    <?= $translation->translate('gene_page_title_criteria') ?>
                                                </a>
                                            </li>
                                        <? endif; ?>
                                        <? if ($gene[$commentAging]): ?>
                                            <li>
                                                <a href="#aging">
                                                    <?= $translation->translate('gene_page_title_aging') ?>
                                                </a>
                                            </li>
                                        <? endif; ?>
                                        <? if ($gene['commentsReferenceLinks']): ?>
                                            <li>
                                                <a href="#reference">
                                                    <?= $translation->translate('gene_page_title_reference') ?>
                                                </a>
                                            </li>
                                        <? endif; ?>
                                    </ul>

                                    <? if ($gene[$commentEvolution]): ?>
                                        <h3><?= $translation->translate('gene_page_title_evolution') ?></h3>

                                        <article id="evolution">
                                            <?= $gene[$commentEvolution] ?>
                                        </article>
                                    <? endif; ?>

                                    <? if ($gene[$commentFunction]): ?>
                                        <h3><?= $translation->translate('gene_page_title_function') ?></h3>
                                        <article id="function">
                                            <?= $gene[$commentFunction] ?>
                                        </article>
                                    <? endif; ?>

                                    <? if ($gene['commentCause']): ?>
                                        <h3><?= $translation->translate('gene_page_title_criteria') ?></h3>
                                        <article id="cause">
                                            <ul class="list list--bulletted">
                                                <?
                                                $commentsCause = new Gene();
                                                $commentsCauseItems = $gene['commentCause'];
                                                $commentsCauseItemsArray = $commentsCause->comma_separated_to_array($commentsCauseItems);
                                                ?>
                                                <? if ($gene['commentsReferenceLinks']): ?>
                                                    <? foreach ($commentsCauseItemsArray as $commentsCauseItem): ?>
                                                        <?
                                                        // SQL keys come already in Russian, giving them a key-like look:
                                                        // // TODO: Это временный костыль
                                                        $commentsCauseItem = (string) mb_strtolower($commentsCauseItem);
                                                        $commentsCauseItem = preg_replace('/\s+/', '_', $commentsCauseItem);
                                                        $commentsCauseItem = preg_replace('/^_/', '', $commentsCauseItem);
                                                        $commentsCauseItem = preg_replace('/[\/+]/', '_', $commentsCauseItem);
                                                        ?>

                                                        <li>
                                                            <?= $translation->translate($commentsCauseItem) ?>
                                                        </li>
                                                    <? endforeach; ?>
                                                <? endif; ?>
                                            </ul>
                                        </article>
                                    <? endif; ?>

                                    <? if ($gene[$commentAging]): ?>
                                        <h3><?= $translation->translate('gene_page_title_aging') ?></h3>
                                        <article id="aging">
                                            <?= $gene[$commentAging] ?>
                                        </article>
                                    <? endif; ?>

                                    <? if ($gene[$expression]): ?>
                                        <h3><?= $translation->translate('gene_page_title_expression') ?></h3>
                                        <article id="expression">
                                            <?php
                                            foreach($gene[$expression] as $name => $expressionValues) {
                                                echo ucfirst($name) . ': ' . $expressionValues['exp_rpkm'] . ' ± ' . substr((string)$expressionValues['var'], 0, 5) . '<br/>';
                                            }
                                            ?>
                                        </article>
                                    <? endif; ?>

                                    <? if ($gene['commentsReferenceLinks']): ?>
                                        <article data-article="reference" class="js_article-reference">
                                            <ul class="list reference-list">
                                                <?
                                                $commentsReference = new Gene();
                                                $commentsReferenceLinks = $gene['commentsReferenceLinks'];
                                                $commentsReferenceLinksArray = $commentsReference->comma_separated_to_array($commentsReferenceLinks);
                                                ?>
                                                <? if ($gene['commentsReferenceLinks']): ?>
                                                    <? foreach ($commentsReferenceLinksArray as $commentsRef): ?>
                                                        <?
                                                            // Formatting a link:
                                                            $commentsRefLink = preg_replace('/\[[0-9\-]*\]\s*/', '', $commentsRef);
                                                        ?>
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
                                            <?= $translation->translate('gene_page_error_no_article_yet') ?>
                                        </div>
                                    </div>
                                </section>
                            <? endif; ?>
                        </div>
                        </section>
                    </div>
                </div>
            </div>

            <? include $_SERVER['DOCUMENT_ROOT'] . '/view/chunks/footer.inc.php'; ?>
            </body>
        <? endif ?>
    <? endforeach; ?>
<? endif; ?>
