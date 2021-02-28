<?php

namespace cms\models\common;

use Yii;

/**
 * This is the model class for table "gene_to_functional_cluster".
 *
 * @property int $id
 * @property int $gene_id
 * @property int $functional_cluster_id
 *
 * @property FunctionalCluster $functionalCluster
 */
class GeneToFunctionalCluster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gene_to_functional_cluster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gene_id', 'functional_cluster_id'], 'integer'],
            [['functional_cluster_id'], 'exist', 'skipOnError' => true, 'targetClass' => FunctionalCluster::className(), 'targetAttribute' => ['functional_cluster_id' => 'id']],
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
            'functional_cluster_id' => 'Functional Cluster ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFunctionalCluster()
    {
        return $this->hasOne(FunctionalCluster::className(), ['id' => 'functional_cluster_id']);
    }

    /**
     * {@inheritdoc}
     * @return GeneToFunctionalClusterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneToFunctionalClusterQuery(get_called_class());
    }
}
