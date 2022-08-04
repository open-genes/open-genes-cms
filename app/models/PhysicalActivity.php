<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * PhysicalActivity
 *
 * @property string $p_value [varchar(255)]
 * @property string $result [varchar(255)]
 * @property string $measurement_taken [varchar(255)]
 * @property string $training_regimen [varchar(255)]
 * @property string $participants [varchar(255)]
 * @property string $duration [varchar(255)]
 * @property string $age [varchar(255)]
 * @property string $age_units [varchar(255)]
 * @property string $experiment_groups_quantity [varchar(255)]
 * @property string $reference [varchar(255)]
 * @property string $expression_change_log [varchar(255)]
 *
 * @property Gene $gene
 * @property Sample $sample
 * @property MeasurementMethod $measurementMethod
 * @property ExpressionEvaluation expressionEvaluation
 * @property ModelOrganism $modelOrganism
 * @property OrganismLine|null $organismLine
 * @property OrganismSex $organismSex
 */
class PhysicalActivity extends \app\models\common\PhysicalActivity
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }
}