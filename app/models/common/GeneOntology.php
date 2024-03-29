<?php

namespace app\models\common;

use app\models\behaviors\ChangelogBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "gene_ontology".
 *
 * @property int $id
 * @property string $ontology_identifier
 * @property string $category
 * @property string $name_en
 * @property string $name_ru
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GeneToOntology[] $geneToOntologies
 */
class GeneOntology extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_ontology';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['ontology_identifier', 'category', 'name_en', 'name_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ontology_identifier' => Yii::t('app', 'Ontology Identifier'),
            'category' => Yii::t('app', 'Category'),
            'name_en' => Yii::t('app', 'Name En'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneToOntologies()
    {
        return $this->hasMany(GeneToOntology::className(), ['gene_ontology_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneOntologyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneOntologyQuery(get_called_class());
    }
}
