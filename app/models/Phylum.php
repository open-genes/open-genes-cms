<?php

namespace app\models;

use app\models\behaviors\ChangelogBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Query;

/**
 * This is the model class for table "age".
 *
 */
class Phylum extends common\Phylum
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            ChangelogBehavior::class
        ];
    }

    public function beforeDelete()
    {
        $genesIds = $this->getLinkedGenesIds();
        Yii::$app->db->createCommand()
            ->update('gene', ['phylum_id' => null], ['in', 'id', $genesIds]);
        return parent::beforeDelete();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenes()
    {
        return $this->hasMany(Gene::class, ['phylum_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFamilyGenes()
    {
        return $this->hasMany(Gene::class, ['family_phylum_id' => 'id']);
    }

    public static function findAllAsArray()
    {
        $result = [];
        $ages = self::find()->all();
        foreach ($ages as $age) {
            $result[$age->id] = $age->name_phylo;
        }

        return $result;
    }

    public function getLinkedGenesIds()
    {
        return $this->getGenes()
            ->select('id')->distinct()->column();
    }

}
