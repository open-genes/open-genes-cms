<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Gene]].
 *
 * @see Gene
 */
class GeneQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Gene[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Gene|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    public function withFunctionalClustersConcat()
    {
        return $this
            ->addSelect([
                'group_concat(concat(functional_cluster.id,\'|\',functional_cluster.name_en)) as functional_clusters_en',
                'group_concat(concat(functional_cluster.id,\'|\',functional_cluster.name_ru)) as functional_clusters_ru'
            ])
            ->withFunctionalClusters();
    }

    public function withFunctionalClusters()
    {
        return $this
            ->join(
                'LEFT JOIN',
                'gene_to_functional_cluster',
                'gene_to_functional_cluster.gene_id = gene.id'
            )
            ->join(
                'LEFT JOIN',
                'functional_cluster',
                'gene_to_functional_cluster.functional_cluster_id = functional_cluster.id'
            );
    }

    public function withExpression()
    {
        return $this
            ->join(
                'LEFT JOIN',
                'gene_expression_in_sample',
                'gene_expression_in_sample.gene_id = gene.id'
            )
            ->join(
                'LEFT JOIN',
                'sample',
                'gene_expression_in_sample.sample_id = sample.id'
            );
    }

    public function withCommentCause()
    {
        return $this
            ->join(
                'LEFT JOIN',
                'gene_to_comment_cause',
                'gene_to_comment_cause.gene_id = gene.id'
            )
            ->join(
                'LEFT JOIN',
                'comment_cause',
                'gene_to_comment_cause.comment_cause_id = comment_cause.id'
            );
    }

    public function withAge()
    {
        return $this
            ->addSelect('age.name_mya as age_mya, age.name_phylo as age_phylo, age.order as age_order')
            ->join(
                'LEFT JOIN',
                'age',
                'gene.age_id = age.id'
            );
    }
}
