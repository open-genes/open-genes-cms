<?php

namespace cms\models;

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
class GeneToFunctionalCluster extends \common\models\GeneToFunctionalCluster
{

}
