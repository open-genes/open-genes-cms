<?php
namespace genes\application\dto;

class GeneListViewDto
{
    /** @var int */
    public $id;
    /** @var PhylumDto */
    public $origin;
    /** @var string */
    public $homologueTaxon;
    /** @var string */
    public $symbol;
    /** @var array */
    public $aliases;
    /** @var string */
    public $name;
    /** @var string */
    public $ncbiId;
    /** @var string */
    public $uniprot;
    /** @var FunctionalClusterDto[] */
    public $functionalClusters;
    /** @var int */
    public $expressionChange;
    /** @var int */
    public $timestamp;
    /** @var array */
    public $terms;

}

