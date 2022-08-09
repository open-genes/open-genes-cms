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
                continue;
            }

            $polymorphism = Polymorphism::find()->where(['name_en' => $data[1]])->one();
            if (empty($polymorphism)) {
                continue;
            }

            $polymorphismType = PolymorphismType::find()->where(['name_en' => $data[11]])->one();
            if (empty($polymorphismType)) {
                continue;
            }

            $organismSex = OrganismSex::find()->where(['name_en' => $data[6]])->one();
            if (empty($organismSex)) {
                continue;
            }

            $ageRelatedChangeType = AgeRelatedChangeType::find()->where(['name_en' => $data[10]])->one();
            if (empty($ageRelatedChangeType)) {
                continue;
            }

            $position = Position::find()->where(['name_en' => $data[2]])->one();
            if (empty($position)) {
                continue;
            }

            $ethnicity = Ethnicity::find()->where(['name_en' => $data[8]])->one();
            if (empty($ethnicity)) {
                continue;
            }

            $studyType = StudyType::find()->where(['name_en' => $data[27]])->one();
            if (empty($studyType)) {
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
                echo 'success: ' . $data[0] . PHP_EOL;
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
                continue;
            }
        }
    }
}
