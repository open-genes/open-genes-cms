<?php

namespace app\service\dataset;

use app\models\AgeRelatedChangeType;
use app\models\Ethnicity;
use app\models\Gene;
use app\models\GeneToLongevityEffect;
use app\models\LongevityEffect;
use app\models\OrganismSex;
use app\models\Polymorphism;
use app\models\PolymorphismType;
use app\models\Position;
use app\models\StudyType;

class GeneToLongevityEffectService
{
    public function addPinkExperiment(array $dataset) {
        $noSave = $saves = [];
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
                $noSave[] = "------ Not found longevity_effect for {$data[0]}, {$data[5]}";
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
                $noSave[] = "------ Not found polymorphism_type for {$data[0]}, {$data[5]}";
                continue;
            }

            $organismSex = OrganismSex::find()->where(['name_en' => $data[6]])->one();
            if (empty($organismSex)) {
                $noSave[] = "------ Not found sex_of_organism for {$data[0]}, {$data[5]}";
                continue;
            }

            $ageRelatedChangeType = AgeRelatedChangeType::find()->where(['name_en' => $data[10]])->one();
            if (empty($ageRelatedChangeType)) {
                $noSave[] = "------ Not found age_related_change_type for {$data[0]}, {$data[5]}";
                continue;
            }

            $position = Position::find()->where(['name_en' => $data[2]])->one();
            if (empty($position)) {
                $noSave[] = "------ Not found position for {$data[0]}, {$data[5]}";
                continue;
            }

            $ethnicity = Ethnicity::find()->where(['name_en' => $data[8]])->one();
            if (empty($ethnicity)) {
                $noSave[] = "------ Not found ethnicity for {$data[0]}, {$data[5]}";
                continue;
            }

            $studyType = StudyType::find()->where(['name_en' => $data[27]])->one();
            if (empty($studyType)) {
                $noSave[] = "------ Not found study_type for {$data[0]}, {$data[5]}";
                continue;
            }

            $params = [
                'gene_id' => $gene->id,
                'position_id' => $position->id,
                'ethnicity_id' => $ethnicity->id,
                'study_type_id' => $studyType->id,
                'polymorphism_id' => $polymorphism->id,
                'sex_of_organism' => $organismSex->id,
                'longevity_effect_id' => $longevity->id,
                'polymorphism_type_id' => $polymorphismType->id,
                'age_related_change_type_id' => $ageRelatedChangeType->id,
                'data_type' => 1,
                'significance' => $data[3],
                'p_value' => $data[4],
                'reference' => $data[5],
                'nucleotide_change' => $data[12],
                'amino_acid_change' => $data[13],
                'polymorphism_other' => $data[14],
                'allele_variant' => $data[15],
                'non_associated_allele' => $data[16],
                'frequency_controls' => $data[17],
                'frequency_experiment' => $data[18],
                'n_of_controls' => $data[19],
                'n_of_experiment' => $data[20],
                'mean_age_of_controls' => $data[21],
                'min_age_of_controls' => $data[22],
                'max_age_of_controls' => $data[23],
                'mean_age_of_experiment' => $data[24],
                'min_age_of_experiment' => $data[25],
                'max_age_of_experiment' => $data[26],
                'pmid' => $data[28],
                'comment_ru' => $data[29],
                'comment_en' => $data[30]
            ];
            try {
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->insert('gene_to_longevity_effect', $params)
                    ->execute();
                $saves[] = '+- success: ' . $data[0];
            } catch (\Exception $exception) {
                var_dump($exception->getMessage());
                continue;
            }
        }
        echo PHP_EOL . '+--------------ERROR--------------+' . PHP_EOL;
        foreach ($noSave as $item) {
            echo $item . PHP_EOL;
        }
        echo PHP_EOL . '+---------------SAVE--------------+' . PHP_EOL;
        foreach ($saves as $item) {
            echo $item . PHP_EOL;
        }
    }
}
