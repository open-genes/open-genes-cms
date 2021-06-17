<?php


namespace app\console\controllers;


use app\models\common\Gene;
use app\service\GeneOntologyServiceInterface;
use yii\console\Controller;

class GetGoTermsController extends Controller
{
    public function actionOntologyMineGene($id)
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = \Yii::$container->get(GeneOntologyServiceInterface::class);
        return $geneOntologyService->mineFromGatewayForGene((int) $id);
    }

    /**
     * @param integer|null $countGenes для какого количества генов собираем записи
     * @param int $countRows сколько записей запрашивать из GO
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function actionGetGoTerms(int $countGenes=null, int $countRows=1000)
    {
        /** @var GeneOntologyServiceInterface $geneOntologyService */
        $geneOntologyService = \Yii::$container->get(GeneOntologyServiceInterface::class);
        $ids = Gene::find()
            ->select('ncbi_id')
            ->limit($countGenes)
            ->column();
        foreach ($ids as $id) {
            echo PHP_EOL . $id;
            try {
                $result = $geneOntologyService->mineFromGatewayForGene((int) $id, $countRows);
                if (isset($result['link_errors'])) {
                    echo ' ERROR ' . $result['link_errors'];
                    continue;
                }
                echo ' ok';
            } catch (\Exception $e) {
                echo ' ERROR ' . $e->getMessage();
            }
        }
        echo PHP_EOL;
    }
    
    /**
     *
     * @param $items
     * @return array
     */
    public function recursiveCamelCase($items) {
        $newItems = [];
        foreach ($items as $k => $item) {
            //todo: это можно сделать одной функцией.
            $newKey = str_replace('-', ' ', $k);
            $newKey = str_replace(['_', '.', ',', '/', '[', ']', '(', ')',], ' ', $newKey);
            $newKey = ucwords($newKey);
            $newKey = str_replace(' ', '', $newKey);
            $newItems[$newKey] = $item;

            if (is_array($item)) {
                $newItems[$newKey] = $this->recursiveCamelCase($item);
            }
        }

        return $newItems;
    }

}