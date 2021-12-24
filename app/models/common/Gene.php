<?php

namespace app\models\common;

use app\models\AgeRelatedChange;
use app\models\GeneInterventionToVitalProcess;
use app\models\GeneToAdditionalEvidence;
use app\models\GeneToLongevityEffect;
use app\models\GeneToProgeria;
use app\models\LifespanExperiment;
use app\models\Orthologs;
use app\models\ProteinToGene;
use Yii;

/**
 * This is the model class for table "gene".
 *
 * @property int $id
 * @property string|null $symbol
 * @property string|null $aliases
 * @property string|null $name
 * @property int|null $ncbi_id
 * @property string|null $uniprot
 * @property string|null $why
 * @property string|null $band
 * @property int|null $locationStart
 * @property int|null $locationEnd
 * @property int|null $orientation
 * @property string|null $accPromoter
 * @property string|null $accOrf
 * @property string|null $accCds
 * @property string|null $references
 * @property string|null $orthologs
 * @property string|null $commentEvolution
 * @property string|null $uniprot_summary_ru
 * @property string|null $commentCause
 * @property string|null $commentAging
 * @property string|null $commentEvolutionEN
 * @property string|null $uniprot_summary_en
 * @property string|null $commentAgingEN
 * @property string|null $commentsReferenceLinks
 * @property int|null $rating
 * @property int $isHidden
 * @property int|null $expressionChange
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $family_phylum_id
 * @property int|null $phylum_id
 * @property string|null $protein_complex_ru
 * @property string|null $protein_complex_en
 * @property int|null $taxon_id
 * @property string|null $ensembl
 * @property string|null $human_protein_atlas
 * @property string|null $ncbi_summary_ru
 * @property string|null $ncbi_summary_en
 * @property string|null $source
 * @property string|null $og_summary_en
 * @property string|null $og_summary_ru
 *
 * @property AgeRelatedChange[] $ageRelatedChanges
 * @property Phylum $phylum
 * @property Phylum $familyPhylum
 * @property GeneExpressionInSample[] $geneExpressionInSamples
 * @property GeneInterventionToVitalProcess[] $geneInterventionToVitalProcesses
 * @property GeneToAdditionalEvidence[] $geneToAdditionalEvidences
 * @property GeneToCommentCause[] $geneToCommentCauses
 * @property GeneToDisease[] $geneToDiseases
 * @property GeneToFunctionalCluster[] $geneToFunctionalClusters
 * @property GeneToLongevityEffect[] $geneToLongevityEffects
 * @property GeneToOntology[] $geneToOntologies
 * @property GeneToProgeria[] $geneToProgerias
 * @property GeneToProteinClass[] $geneToProteinClasses
 * @property LifespanExperiment[] $lifespanExperiments
 * @property ProteinToGene[] $proteinToGenes
 * @property ProteinToGene[] $proteinToGenes0
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
            [['ncbi_id', 'locationStart', 'locationEnd', 'orientation', 'rating', 'isHidden', 'expressionChange', 'created_at', 'updated_at', 'family_phylum_id', 'phylum_id', 'taxon_id'], 'integer'],
            [['commentEvolution', 'uniprot_summary_ru', 'commentCause', 'commentAging', 'commentEvolutionEN', 'uniprot_summary_en', 'commentAgingEN', 'commentsReferenceLinks', 'protein_complex_ru', 'protein_complex_en', 'human_protein_atlas', 'ncbi_summary_ru', 'ncbi_summary_en', 'og_summary_en', 'og_summary_ru'], 'string'],
            [['symbol', 'aliases', 'name', 'uniprot', 'band', 'accPromoter', 'accOrf', 'accCds'], 'string', 'max' => 120],
            [['why', 'references', 'orthologs'], 'string', 'max' => 1000],
            [['ensembl'], 'string', 'max' => 255],
            [['phylum_id'], 'exist', 'skipOnError' => true, 'targetClass' => Phylum::className(), 'targetAttribute' => ['phylum_id' => 'id']],
            [['family_phylum_id'], 'exist', 'skipOnError' => true, 'targetClass' => Phylum::className(), 'targetAttribute' => ['family_phylum_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'aliases' => 'Aliases',
            'name' => 'Name',
            'ncbi_id' => 'Ncbi ID',
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
            'uniprot_summary_ru' => 'Comment Function',
            'commentCause' => 'Comment Cause',
            'commentAging' => 'Comment Aging',
            'commentEvolutionEN' => 'Comment Evolution En',
            'uniprot_summary_en' => 'Comment Function En',
            'commentAgingEN' => 'Comment Aging En',
            'commentsReferenceLinks' => 'Comments Reference Links',
            'rating' => 'Rating',
            'isHidden' => 'Is Hidden',
            'expressionChange' => 'Expression Change',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'family_phylum_id' => 'Family Phylum ID',
            'phylum_id' => 'Phylum ID',
            'protein_complex_ru' => 'Protein Complex Ru',
            'protein_complex_en' => 'Protein Complex En',
            'taxon_id' => 'Taxon ID',
            'ensembl' => 'Ensembl',
            'human_protein_atlas' => 'Human Protein Atlas',
            'ncbi_summary_ru' => 'Ncbi Summary Ru',
            'ncbi_summary_en' => 'Ncbi Summary En',
            'og_summary_en' => 'Og Summary En',
            'og_summary_ru' => 'Og Summary Ru',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgeRelatedChanges()
    {
        return $this->hasMany(AgeRelatedChange::class, ['gene_id' => 'id']);
    }

    /**
     * Gets query for [[Phylum]].
     *
     * @return \yii\db\ActiveQuery|PhylumQuery
     */
    public function getPhylum()
    {
        return $this->hasOne(Phylum::className(), ['id' => 'phylum_id']);
    }

    /**
     * Gets query for [[Phylum]].
     *
     * @return \yii\db\ActiveQuery|PhylumQuery
     */
    public function getFamilyPhylum()
    {
        return $this->hasOne(Phylum::className(), ['id' => 'family_phylum_id']);
    }

    /**
     * Gets query for [[GeneExpressionInSamples]].
     *
     * @return \yii\db\ActiveQuery|GeneExpressionInSampleQuery
     */
    public function getGeneExpressionInSamples()
    {
        return $this->hasMany(GeneExpressionInSample::className(), ['gene_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneInterventionToVitalProcesses()
    {
        return $this->hasMany(GeneInterventionToVitalProcess::class, ['gene_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneToAdditionalEvidences()
    {
        return $this->hasMany(GeneToAdditionalEvidence::class, ['gene_id' => 'id']);
    }

    /**
     * Gets query for [[GeneToCommentCauses]].
     *
     * @return \yii\db\ActiveQuery|GeneToCommentCauseQuery
     */
    public function getGeneToCommentCauses()
    {
        return $this->hasMany(GeneToCommentCause::className(), ['gene_id' => 'id']);
    }

    /**
     * Gets query for [[GeneToDiseases]].
     *
     * @return \yii\db\ActiveQuery|GeneToDiseaseQuery
     */
    public function getGeneToDiseases()
    {
        return $this->hasMany(GeneToDisease::className(), ['gene_id' => 'id']);
    }

    /**
     * Gets query for [[GeneToFunctionalClusters]].
     *
     * @return \yii\db\ActiveQuery|GeneToFunctionalClusterQuery
     */
    public function getGeneToFunctionalClusters()
    {
        return $this->hasMany(GeneToFunctionalCluster::className(), ['gene_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneToLongevityEffects()
    {
        return $this->hasMany(GeneToLongevityEffect::class, ['gene_id' => 'id']);
    }

    /**
     * Gets query for [[GeneToOntologies]].
     *
     * @return \yii\db\ActiveQuery|GeneToOntologyQuery
     */
    public function getGeneToOntologies()
    {
        return $this->hasMany(GeneToOntology::className(), ['gene_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneToProgerias()
    {
        return $this->hasMany(GeneToProgeria::class, ['gene_id' => 'id']);
    }

    /**
     * Gets query for [[GeneToProteinClasses]].
     *
     * @return \yii\db\ActiveQuery|GeneToProteinClassQuery
     */
    public function getGeneToProteinClasses()
    {
        return $this->hasMany(GeneToProteinClass::className(), ['gene_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLifespanExperiments()
    {
        return $this->hasMany(LifespanExperiment::class, ['gene_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProteinToGenes()
    {
        return $this->hasMany(ProteinToGene::class, ['gene_id' => 'id']);
    }

    /**
     * Gets query for [[ProteinToGenes0]].
     *
     * @return \yii\db\ActiveQuery|ProteinToGeneQuery
     */
    public function getProteinToGenes0()
    {
        return $this->hasMany(ProteinToGene::className(), ['regulated_gene_id' => 'id']);
    }

    /**
     * Gets query for [[Sources]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasMany(Source::class, ['id' => 'source_id'])
            ->viaTable('gene_to_source', ['gene_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrthologs()
    {
        return $this->hasMany(Orthologs::class, ['id' => 'ortholog_id'])
            ->viaTable('gene_to_orthologs', ['gene_id' => 'id']);
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
