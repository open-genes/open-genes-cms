<?php

namespace cms\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_protein_activity".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $protein_activity_id
 * @property int $protein_activity_object_id
 * @property int $process_localization_id
 * @property string $reference
 * @property string $comment
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProteinActivity $proteinActivity
 * @property Gene $gene
 * @property ProcessLocalization $processLocalization
 * @property ProteinActivityObject $proteinActivityObject
 */
class GeneToProteinActivity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_protein_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'protein_activity_id', 'protein_activity_object_id', 'process_localization_id', 'created_at', 'updated_at'], 'integer'],
            [['reference', 'comment_en', 'comment_ru'], 'string'],
            [['protein_activity_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProteinActivity::class, 'targetAttribute' => ['protein_activity_id' => 'id']],
            [['gene_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gene::class, 'targetAttribute' => ['gene_id' => 'id']],
            [['process_localization_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessLocalization::class, 'targetAttribute' => ['process_localization_id' => 'id']],
            [['protein_activity_object_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProteinActivityObject::class, 'targetAttribute' => ['protein_activity_object_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gene_id' => 'Gene ID',
            'protein_activity_id' => 'Protein Activity ID',
            'protein_activity_object_id' => 'Protein Activity Object ID',
            'process_localization_id' => 'Process Localization ID',
            'reference' => 'Reference',
            'comment' => 'Comment',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProteinActivity()
    {
        return $this->hasOne(ProteinActivity::class, ['id' => 'protein_activity_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGene()
    {
        return $this->hasOne(Gene::class, ['id' => 'gene_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProcessLocalization()
    {
        return $this->hasOne(ProcessLocalization::class, ['id' => 'process_localization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProteinActivityObject()
    {
        return $this->hasOne(ProteinActivityObject::class, ['id' => 'protein_activity_object_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToProteinActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToProteinActivityQuery(get_called_class());
    }
}
