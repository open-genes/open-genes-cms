<?php

namespace app\console\controllers;

use Exception;
use Yii;
use yii\console\Controller;

class DropDataController extends Controller
{
    public function actionClearOntology() {
        $sql = Yii::$app->db;

        try {
            $sql->createCommand(
                'DELETE FROM gene_ontology_to_aging_mechanism_visible'
            )->execute();
            echo 'success delete: gene_ontology_to_aging_mechanism_visible' . PHP_EOL;
        } catch (Exception $exception) {
            echo '-- error: ' . $exception->getMessage() . PHP_EOL;
        }

        try {
            $sql->createCommand(
                'DELETE FROM aging_mechanism_to_gene_ontology'
            )->execute();
            echo 'success delete: aging_mechanism_to_gene_ontology' . PHP_EOL;
        } catch (Exception $exception) {
            echo '-- error: ' . $exception->getMessage() . PHP_EOL;
        }

        try {
            $sql->createCommand(
                'DELETE FROM gene_to_ontology'
            )->execute();
            echo 'success delete: gene_to_ontology' . PHP_EOL;
        } catch (Exception $exception) {
            echo '-- error: ' . $exception->getMessage() . PHP_EOL;
        }

        try {
            $sql->createCommand(
                'DELETE FROM gene_ontology_relation'
            )->execute();
            echo 'success delete: gene_ontology_relation' . PHP_EOL;
        } catch (Exception $exception) {
            echo '-- error: ' . $exception->getMessage() . PHP_EOL;
        }

        try {
            $sql->createCommand(
                'DELETE FROM aging_mechanism'
            )->execute();
            echo 'success delete: aging_mechanism' . PHP_EOL;
        } catch (Exception $exception) {
            echo '-- error: ' . $exception->getMessage() . PHP_EOL;
        }

        try {
            $sql->createCommand(
                'DELETE FROM gene_ontology'
            )->execute();
            echo 'success delete: gene_ontology' . PHP_EOL;
        } catch (Exception $exception) {
            echo '-- error: ' . $exception->getMessage() . PHP_EOL;
        }
    }
}
