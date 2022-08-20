<?php

namespace app\service\dataset;

use app\models\AgeRelatedChangeType;
use app\models\Ethnicity;
use app\models\Gene;
use app\models\common\GeneToLongevityEffect;
use app\models\LongevityEffect;
use app\models\OrganismSex;
use app\models\Polymorphism;
use app\models\PolymorphismType;
use app\models\Position;
use app\models\StudyType;

class GeneToLongevityEffectService
{
    public function addPinkExperiment(array $dataset) {
        foreach ($dataset as $data) {
            $gene = Gene::find()->where(['symbol' => trim($data[0])])->one();
            if (empty($gene)) {
                continue;
            }

            GeneToLongevityEffect::deleteAll(
                "gene_id = {$gene->id} AND data_type = 1 AND ( longevity_effect_id = 8 OR longevity_effect_id = 1 )"
            );

            $longevity = LongevityEffect::find()->where(['name_en' => $data[7]])->one();
            if (empty($longevity)) {
                echo PHP_EOL . "------ Not found longevity_effect for {$data[0]}, {$data[5]}" . PHP_EOL;
                continue;
            }

            $polymorphism = Polymorphism::find()->where(['name_en' => $data[1]])->one();
            if (empty($polymorphism)) {
                $polymorphism = new Polymorphism();
                $polymorphism->name_ru = $data[1];
                $polymorphism->name_en = $data[1];
                $polymorphism->save();
                echo PHP_EOL . "++++++ SAVE {$data[1]} - Polymorphism" . PHP_EOL;
            }

            $polymorphismType = PolymorphismType::find()->where(['name_en' => $data[11]])->one();
            if (empty($polymorphismType)) {
                echo PHP_EOL . "------ Not found polymorphism_type for {$data[0]}, {$data[5]}" . PHP_EOL;
                continue;
            }

            $organismSex = OrganismSex::find()->where(['name_en' => $data[6]])->one();
            if (empty($organismSex)) {
                echo PHP_EOL . "------ Not found sex_of_organism for {$data[0]}, {$data[5]}" . PHP_EOL;
                continue;
            }

            $ageRelatedChangeType = AgeRelatedChangeType::find()->where(['name_en' => $data[10]])->one();
            if (empty($ageRelatedChangeType)) {
                echo PHP_EOL . "------ Not found age_related_change_type for {$data[0]}, {$data[5]}" . PHP_EOL;
                continue;
            }

            $position = Position::find()->where(['name_en' => $data[2]])->one();
            if (empty($position)) {
                echo PHP_EOL . "------ Not found position for {$data[0]}, {$data[5]}" . PHP_EOL;
                continue;
            }

            $ethnicity = Ethnicity::find()->where(['name_en' => $data[8]])->one();
            if (empty($ethnicity)) {
                echo PHP_EOL . "------ Not found ethnicity for {$data[0]}, {$data[5]}" . PHP_EOL;
                continue;
            }

            $studyType = StudyType::find()->where(['name_en' => $data[27]])->one();
            if (empty($studyType)) {
                echo PHP_EOL . "------ Not found study_type for {$data[0]}, {$data[5]}" . PHP_EOL;
                continue;
            }

            $geneToLongevityEffect = new GeneToLongevityEffect();
            $geneToLongevityEffect->gene_id = $gene->id;
            $geneToLongevityEffect->position_id = $position->id;
            $geneToLongevityEffect->ethnicity_id = $ethnicity->id;
            $geneToLongevityEffect->study_type_id = $studyType->id;
            $geneToLongevityEffect->polymorphism_id = $polymorphism->id;
            $geneToLongevityEffect->sex_of_organism = $organismSex->id;
            $geneToLongevityEffect->longevity_effect_id = $longevity->id;
            $geneToLongevityEffect->polymorphism_type_id = $polymorphismType->id;
            $geneToLongevityEffect->age_related_change_type_id = $ageRelatedChangeType->id;
            $geneToLongevityEffect->significance = $data[3];
            $geneToLongevityEffect->p_value = $data[4];
            $geneToLongevityEffect->reference = $data[5];
            $geneToLongevityEffect->nucleotide_change = $data[12];
            $geneToLongevityEffect->amino_acid_change = $data[13];
            $geneToLongevityEffect->polymorphism_other = $data[14];
            $geneToLongevityEffect->allele_variant = $data[15];
            $geneToLongevityEffect->non_associated_allele = $data[16];
            $geneToLongevityEffect->frequency_controls = $data[17];
            $geneToLongevityEffect->frequency_experiment = $data[18];
            $geneToLongevityEffect->n_of_controls = $data[19];
            $geneToLongevityEffect->n_of_experiment = $data[20];
            $geneToLongevityEffect->mean_age_of_controls = $data[21];
            $geneToLongevityEffect->min_age_of_controls = $data[22];
            $geneToLongevityEffect->max_age_of_controls = $data[23];
            $geneToLongevityEffect->mean_age_of_experiment = $data[24];
            $geneToLongevityEffect->min_age_of_experiment = $data[25];
            $geneToLongevityEffect->max_age_of_experiment = $data[26];
            $geneToLongevityEffect->pmid = $data[28];
            $geneToLongevityEffect->comment_ru = $data[29];
            $geneToLongevityEffect->comment_en = $data[30];
            try {
                $geneToLongevityEffect->save();
                $titleFile = date('Ymd__His') . '_geneToLongevityEffect.csv';
                $file = fopen(\Yii::getAlias('@app/') . 'storage/datalogs/' . $titleFile, 'a');
                fwrite($file, PHP_EOL . "
                gene_longevity_effect= {$geneToLongevityEffect->id},
                gene_id= {$geneToLongevityEffect->gene_id} ? {$gene->id} , position_id= {$geneToLongevityEffect->position_id} ? {$position->id} , ethnicity_id= {$geneToLongevityEffect->ethnicity_id} ? {$ethnicity->id} , study_type_id= {$geneToLongevityEffect->study_type_id} ? {$studyType->id} , polymorphism_id= {$geneToLongevityEffect->polymorphism_id} ? {$polymorphism->id} , sex_of_organism= {$geneToLongevityEffect->sex_of_organism} ? {$organismSex->id} ,longevity_effect_id= {$geneToLongevityEffect->longevity_effect_id} ? {$longevity->id} ,polymorphism_type_id= {$geneToLongevityEffect->polymorphism_type_id} ? {$polymorphismType->id} ,age_related_change_type_id= {$geneToLongevityEffect->age_related_change_type_id} ? {$ageRelatedChangeType->id} ,
                significance= {$data[3]} ,p_value= {$data[4]} ,reference= {$data[5]} ,nucleotide_change= {$data[12]} ,amino_acid_change= {$data[13]} ,polymorphism_other= {$data[14]} ,allele_variant= {$data[15]} ,non_associated_allele= {$data[16]} ,frequency_controls= {$data[17]} ,frequency_experiment= {$data[18]} ,n_of_controls= {$data[19]} ,n_of_experiment= {$data[20]} ,mean_age_of_controls= {$data[21]} ,min_age_of_controls= {$data[22]} ,max_age_of_controls= {$data[23]} ,mean_age_of_experiment= {$data[24]} ,min_age_of_experiment= {$data[25]} ,max_age_of_experiment= {$data[26]} ,pmid= {$data[28]} ,comment_ru= {$data[29]} ,comment_en= {$data[30]} ----------;
                " . PHP_EOL);
                fclose($file);
                echo '+- success: ' . $data[0] . PHP_EOL;
                if ($data[0] == 'APOC3') {
                    exit;
                }
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
                continue;
            }
        }
    }
}
