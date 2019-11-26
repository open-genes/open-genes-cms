<?php
namespace genes\infrastructure\dataProvider;

use common\models\GeneExpressionInSample;

class GeneExpressionDataProvider implements GeneExpressionDataProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getByGeneId(int $geneId, string $lang): array
    {
        $sampleNameField = $lang == 'en-US' ? 'name_en' : 'name_ru';
        return GeneExpressionInSample::find()
            ->select("sample.{$sampleNameField} as name, expression_value as exp_rpkm") // todo
            ->innerJoin('sample', 'gene_expression_in_sample.sample_id=sample.id')
            ->where(['gene_id' => $geneId])
            ->orderBy('exp_rpkm DESC')
            ->asArray()
            ->all();
    }
}