<?php
namespace genes\application\service;

use genes\infrastructure\dataProvider\PhylumDataProviderInterface;

class PhylumInfoService implements PhylumInfoServiceInterface
{
    /** @var PhylumDataProviderInterface  */
    private $phylumDataProvider;

    public function __construct(
        PhylumDataProviderInterface $phylumDataProvider
    )
    {
        $this->phylumDataProvider = $phylumDataProvider;
    }

    /** @inheritDoc */
    public function getAllPhyla(): array
    {
        $phylaArray = $this->phylumDataProvider->getAllPhyla();
        $phylaDtos = [];
        foreach ($phylaArray as $phylumArray) {
            $phylaDtos[] = [
                'id' => (int)$phylumArray['id'],
                'phylum' => $phylumArray['name_phylo'],
                'age' => $phylumArray['name_mya'],
                'order' => (int)$phylumArray['order'],
            ];
        }

        return $phylaDtos;
    }
}