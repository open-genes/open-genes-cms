<?php

namespace app\console\service;

use app\models\Disease;
use yii\httpclient\Client;

class ParseICDService implements ParseICDServiceInterface
{
    private $apiUrl;
    private $clientId;
    private $clientSecret;

    public function __construct($apiUrl, $clientId, $clientSecret)
    {
        $this->apiUrl = $apiUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getICDTree(bool $onlyNew = true, array $geneNcbiIdsArray = [])
    {
        $httpClient = new Client();
        $diseases = Disease::find()
            ->where('icd_code is not null')
            ->andWhere('parent_icd_code is null')
            ->all();
        echo PHP_EOL;

        $token = $this->getToken();

        foreach ($diseases as $disease) {
            echo $disease->name_en . ' ' . $disease->icd_code . ' ';
            $result = $httpClient->createRequest()
                ->setUrl("{$this->apiUrl}/release/10/2019/{$disease->icd_code}/")
                ->setHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'API-Version' => 'v2',
                    'Accept-Language' => 'en',
                    'accept' => 'application/json',
                ])
                ->send();
            $parsedResult = json_decode($result->content, true);

            $parentIcdCodeArray = explode('/', $parsedResult['parent'][0]);
            $parentIcdCode = end($parentIcdCodeArray);

            $name = $parsedResult['title']['@value'];
            $disease->parent_icd_code = $parentIcdCode;
            $disease->icd_name_en = $name;
            $disease->save();

            $parentDisease = Disease::find()
                ->where(['icd_code' => $parentIcdCode])->one();
            if (!$parentDisease) {
                $parentDisease = new Disease();
                $parentDisease->icd_code = $parentIcdCode;
                $parentDisease->save();
            }
            echo ' - ' . $name . ', parent ' . $parentIcdCode;
            echo PHP_EOL;
            usleep(100000);
        }
    }

    private function getToken()
    {
        $httpClient = new Client();

        $tokenRequest = $httpClient->createRequest()
            ->setUrl("https://icdaccessmanagement.who.int/connect/token")
            ->setMethod('POST')
            ->setData([
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => "icdapi_access",
                'grant_type' => "client_credentials"
            ])
            ->send();
        return json_decode($tokenRequest->content, true)['access_token'];
    }
}