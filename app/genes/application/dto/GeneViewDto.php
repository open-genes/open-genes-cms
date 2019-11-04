<?php
namespace genes\application\dto;

class GeneViewDto
{
    /** @var int */
    public $id;
    /** @var int */
    public $ageMya;
    /** @var string */
    public $agePhylo;
    /** @var string */
    public $symbol;
    /** @var array */
    public $aliases;
    /** @var string */
    public $name;
    /** @var string */
    public $entrezGene;
    /** @var string */
    public $uniprot;
    /** @var string */
    public $commentEvolution;
    /** @var string */
    public $commentFunction;
    /** @var array */
    public $commentCause;
    /** @var string */
    public $commentAging;
    /** @var array */
    public $commentsReferenceLinks;
    /** @var string */
    public $rating;
    /** @var array */
    public $functionalClusters;
    /** @var array [$geneName => $geneExpression[]] */
    public $expression;
    /** @var string */
    public $expressionChange;

//    public $isHidden;
//    public $references;
//    public $orthologs;
//    public $dateAdded;
//    public $userEdited;
//    public $hylo;
//    public $why;
//    public $band;
//    public $locationStart;
//    public $locationEnd;
//    public $orientation;
//    public $accPromoter;
//    public $accOrf;
//    public $accCds;
}

