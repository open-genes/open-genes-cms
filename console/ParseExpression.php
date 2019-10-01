<?php

class ParseExpression
{
    const NCBI_URL = 'https://www.ncbi.nlm.nih.gov/';
    const DB_DSN = 'mysql:host=localhost;dbname=u0610688_genes;charset=UTF8';
    const DB_USER = 'u0610688_genes';
    const DB_PASS = 'B1y3R5c8';

    /** @var PDO */
    private $dbConnection;

    public function run($fromId = 1)
    {
        $genes = $this->getGenes($fromId);
        $counter = 1;
        $count = count($genes);
        foreach ($genes as $gene) {
            try {
                echo 'parsing info for gene id=' . $gene['ID'] . ' entrezGene=' . $gene['entrezGene'] . ' (' . $counter . ' from ' . $count . ') ... ';
                $url = self::NCBI_URL . 'gene/' . $gene['entrezGene'] . '/expression/details?p$l=Expression';
                $geneInfoPage = $this->makeRequest($url);
                $geneExpression = $this->parseExpressionFromPage($geneInfoPage);
                $this->writeGeneExpression((int)$gene['ID'], $geneExpression);
                echo 'success' . PHP_EOL;
                $counter++;
                sleep(2);
            } catch (Exception $e) {
                echo PHP_EOL . 'ERROR ' . $e->getMessage() . PHP_EOL;
            }
        }
    }

    /**
     * @param int $geneId
     * @param array $expressionArray
     * @throws Exception
     */
    protected function writeGeneExpression(int $geneId, array $expressionArray)
    {
        $sql = 'update argb set expression=:expression where id=:id';
        $query = $this->getDbConnection()->prepare($sql);
        $query->bindParam(':expression', json_encode($expressionArray));
        $query->bindParam(':id', $geneId);
        if(!$query->execute()) {
            throw new \Exception('Couldn\'t save gene info, ' . var_export($query->errorInfo(), true));
        }
    }

    protected function getGenes(int $fromId): array
    {
        $query = 'select ID, entrezGene from argb where ID >= ' . $fromId;
        return $this->getDbConnection()->query($query)->fetchAll();
    }

    /**
     * @param string $geneInfoPage
     * @return array
     * @throws Exception
     */
    protected function parseExpressionFromPage(string $geneInfoPage): array
    {
        preg_match('/tissues_data = ({.*});/', $geneInfoPage, $result);
        $expressionDataString = $result[1] ?? '';
        $expressionDataJson = str_replace("'", "\"", $expressionDataString);
        $expressionArray = json_decode($expressionDataJson, true);
        if(is_array($expressionArray)) {
            $resultArray = [];
            foreach($expressionArray as $name => $expressionValues) {
                if(isset($expressionValues['exp_rpkm'])) {
                    if($expressionValues['exp_rpkm'] > 0) {
                        $resultArray[$name]['full_rpkm'] = $expressionValues['full_rpkm'];
                        $resultArray[$name]['exp_rpkm'] = $expressionValues['exp_rpkm'];
                        $resultArray[$name]['var'] = $expressionValues['var'];
                        $resultArray[$name]['project_desc'] = $expressionValues['project_desc'];
                    }
                } else {
                    throw new Exception('Couldn\'t parse gene info, $expressionArray = ' . var_export($expressionArray, true));
                }
            }
            uasort( $resultArray, function ($item1, $item2) {
                return $item2['exp_rpkm'] <=> $item1['exp_rpkm'];
            });
        } else {
            throw new \Exception('Couldn\'t parse gene info, $geneInfoPage = ' . $geneInfoPage);
        }
        return $resultArray;
    }

    protected function makeRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        return curl_exec($ch);
    }

    private function getDbConnection()
    {
        if(!$this->dbConnection) {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ];
            $this->dbConnection = new PDO(self::DB_DSN, self::DB_USER, self::DB_PASS, $options);
        }
        return $this->dbConnection;
    }
}

$parser = new ParseExpression();
$parser->run();