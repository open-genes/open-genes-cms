<?php

namespace genes\models;

use Yii;

/**
 *
 * @property int $ID
 * @property string $agePhylo
 * @property int $ageMya
 * @property string $symbol
 * @property string $aliases
 * @property string $name
 * @property int $entrezGene
 * @property string $uniprot
 * @property string $why
 * @property string $band
 * @property int $locationStart
 * @property int $locationEnd
 * @property int $orientation
 * @property string $accPromoter
 * @property string $accOrf
 * @property string $accCds
 * @property string $references
 * @property string $orthologs
 * @property string $commentEvolution
 * @property string $commentFunction
 * @property string $commentCause
 * @property string $commentAging
 * @property string $commentEvolutionEN
 * @property string $commentFunctionEN
 * @property string $commentAgingEN
 * @property string $commentsReferenceLinks
 * @property int $rating
 * @property string $functionalClusters
 * @property int $dateAdded
 * @property string $userEdited
 * @property int $isHidden
 * @property string $expression
 * @property string $expressionEN
 */
class Gene extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ageMya', 'entrezGene', 'locationStart', 'locationEnd', 'orientation', 'rating', 'dateAdded', 'isHidden'], 'integer'],
            [['dateAdded'], 'required'],
            [['expression', 'expressionEN'], 'string'],
            [['agePhylo', 'symbol', 'aliases', 'name', 'uniprot', 'band', 'accPromoter', 'accOrf', 'accCds'], 'string', 'max' => 120],
            [['why', 'references', 'orthologs', 'functionalClusters'], 'string', 'max' => 1000],
            [['commentEvolution', 'commentFunction', 'commentCause', 'commentAging', 'commentEvolutionEN', 'commentFunctionEN', 'commentAgingEN'], 'string', 'max' => 1500],
            [['commentsReferenceLinks'], 'string', 'max' => 2000],
            [['userEdited'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'agePhylo' => 'Age Phylo',
            'ageMya' => 'Age Mya',
            'symbol' => 'Symbol',
            'aliases' => 'Aliases',
            'name' => 'Name',
            'entrezGene' => 'Entrez Gene',
            'uniprot' => 'Uniprot',
            'why' => 'Why',
            'band' => 'Band',
            'locationStart' => 'Location Start',
            'locationEnd' => 'Location End',
            'orientation' => 'Orientation',
            'accPromoter' => 'Acc Promoter',
            'accOrf' => 'Acc Orf',
            'accCds' => 'Acc Cds',
            'references' => 'References',
            'orthologs' => 'Orthologs',
            'commentEvolution' => 'Comment Evolution',
            'commentFunction' => 'Comment Function',
            'commentCause' => 'Comment Cause',
            'commentAging' => 'Comment Aging',
            'commentEvolutionEN' => 'Comment Evolution En',
            'commentFunctionEN' => 'Comment Function En',
            'commentAgingEN' => 'Comment Aging En',
            'commentsReferenceLinks' => 'Comments Reference Links',
            'rating' => 'Rating',
            'functionalClusters' => 'Functional Clusters',
            'dateAdded' => 'Date Added',
            'userEdited' => 'User Edited',
            'isHidden' => 'Is Hidden',
            'expression' => 'Expression',
            'expressionEN' => 'Expression En',
        ];
    }

    /**
     * {@inheritdoc}
     * @return GeneQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneQuery(get_called_class());
    }
}