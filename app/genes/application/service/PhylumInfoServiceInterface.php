<?php
namespace genes\application\service;


use genes\application\dto\PhylumDto;

interface PhylumInfoServiceInterface
{
    /**
     * @return PhylumDto[]
     */
    public function getAllPhyla(): array;

}