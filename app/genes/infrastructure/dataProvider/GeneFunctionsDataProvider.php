<?php
namespace genes\infrastructure\dataProvider;

use common\models\GeneToProteinActivity;

class GeneFunctionsDataProvider implements GeneFunctionsDataProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getByGeneId(int $geneId, string $lang): array
    {
        $nameField = $lang == 'en-US' ? 'name_en' : 'name_ru';
        $commentField = $lang == 'en-US' ? 'comment_en' : 'comment_ru';
        return GeneToProteinActivity::find()
            ->select([
                "protein_activity.{$nameField} as proteinActivity",
                "protein_activity_object.{$nameField} as proteinActivityObject",
                "process_localization.{$nameField} as processLocalization",
                "gene_to_protein_activity.{$commentField} as comment"])
            ->distinct()
            ->innerJoin('protein_activity', 'gene_to_protein_activity.protein_activity_id=protein_activity.id')
            ->innerJoin('protein_activity_object', 'gene_to_protein_activity.protein_activity_object_id=protein_activity_object.id')
            ->leftJoin('process_localization', 'gene_to_protein_activity.process_localization_id=process_localization.id')
            ->where(['gene_id' => $geneId])
            ->asArray()
            ->all();
    }
}