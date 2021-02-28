<?php

namespace cms\models;

use cms\models\behaviors\ChangelogBehavior;
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
class GeneToFunctionalCluster extends common\GeneToFunctionalCluster
{


    public function behaviors()
    {
        return [
            ChangelogBehavior::class
        ];
    }
}
