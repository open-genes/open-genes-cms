<?php

namespace cms\models;


/**
 */
class GeneToFunction extends \common\models\GeneToFunction
{
    public function getAllByGeneId(int $geneId)
    {
        return self::find()
            ->join(
                'INNER JOIN',
                'gene_to_function_relation_type',
                'gene_to_function.gene_to_function_relation_type_id = gene_to_function_relation_type.id')
            ->join(
                'INNER JOIN',
                'function',
                'gene_to_function.function_id = function.id'
            )
            ->where(['gene_id' => $geneId])
            ->all();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'function_id' => 'Функция',
            'gene_to_function_relation_type_id' => 'Связь',
            'reference' => 'Источник',
        ];
    }
}