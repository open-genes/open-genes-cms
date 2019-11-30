<?php
namespace genes\application\dto;

class GeneListViewDto
{
    /** @var int */
    public $id;
    /** @var string */
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
    /** @var FunctionalClusterDto[] */
    public $functionalClusters;
    /** @var string */
    public $expressionChange;

}

