<?php
namespace genes\infrastructure\dataProvider;


interface PhylumDataProviderInterface
{

    /**
     * @return array
     */
    public function getAllPhyla(): array;

}