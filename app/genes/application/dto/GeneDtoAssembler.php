<?php


namespace genes\application\dto;


use yii\base\Exception;

class GeneDtoAssembler implements GeneDtoAssemblerInterface
{

    public function mapViewDto(array $geneArray, string $lang): GeneFullViewDto
    {
        $geneDto = new GeneFullViewDto();
        $geneCommentsReferenceLinks = [];
        $geneCommentsReferenceLinksSource = $geneArray['commentsReferenceLinks'] ? explode(',', $geneArray['commentsReferenceLinks']) : [];
        foreach ($geneCommentsReferenceLinksSource as $commentsRef) {
            $commentsRefLink = preg_replace('/^(\s?<br>)?\s*\[[0-9\-]*\s*[[0-9\-]*]\s*/', '', $commentsRef);
            $geneCommentsReferenceLinks[$commentsRefLink] = $commentsRef;
        }
        $geneDto->id = (int)$geneArray['id'];
        $geneDto->origin = $this->prepareOrigin($geneArray);
        $geneDto->homologueTaxon = (string)$geneArray['taxon_name'];
        $geneDto->symbol = (string)$geneArray['symbol'];
        $geneDto->aliases = $geneArray['aliases'] ? explode(' ', $geneArray['aliases']) : [];
        $geneDto->name = (string)$geneArray['name'];
        $geneDto->ncbiId = (string)$geneArray['ncbi_id'];
        $geneDto->uniprot = (string)$geneArray['uniprot'];
        $geneDto->commentCause =  $geneArray['comment_cause'] ? explode(',', $geneArray['comment_cause']) : [];
        $geneDto->proteinClasses =  $geneArray['protein_class'] ? explode('||', $geneArray['protein_class']) : []; // todo одинаковый сепаратор для всех group_concat
        $geneDto->commentEvolution = $geneArray['comment_evolution'];
        $geneDto->commentFunction = (string)$geneArray['comment_function'];
        $geneDto->commentAging = (string)$geneArray['comment_aging'];
        $geneDto->commentsReferenceLinks = $geneCommentsReferenceLinks;
        $geneDto->rating = $geneArray['rating'];
        $geneDto->functionalClusters = $this->mapFunctionalClusterDtos($geneArray['functional_clusters']);
        $geneDto->expressionChange = (int)$geneArray['expressionChange'];
        $geneDto->why = explode(',', $geneArray['why']);
        $geneDto->band = (string)$geneArray['band'];
        $geneDto->locationStart = (string)$geneArray['locationStart'];
        $geneDto->locationEnd = (string)$geneArray['locationEnd'];
        $geneDto->orientation = (string)$geneArray['orientation'];
        $geneDto->accPromoter = (string)$geneArray['accPromoter'];
        $geneDto->accOrf = (string)$geneArray['accOrf'];
        $geneDto->accCds = (string)$geneArray['accCds'];
        $geneDto->orthologs = $this->prepareOrthologs($geneArray['orthologs']);
        $geneDto->timestamp = $this->prepareTimestamp($geneArray);

        return $geneDto;
    }

    public function mapLatestViewDto(array $geneArray): LatestGeneViewDto
    {
        $geneDto = new LatestGeneViewDto();
        $geneDto->id = (int)$geneArray['id'];
        $geneDto->origin = $this->prepareOrigin($geneArray);
        $geneDto->homologueTaxon = $geneArray['taxon_name'];
        $geneDto->symbol = $geneArray['symbol'];
        $geneDto->timestamp = $this->prepareTimestamp($geneArray);
        return $geneDto;
    }

    public function mapListViewDto(array $geneArray, string $lang): GeneListViewDto
    {
        $geneDto = new GeneListViewDto();
        $geneDto->id = (int)$geneArray['id'];
        $geneDto->name = (string)$geneArray['name'];
        $geneDto->origin = $this->prepareOrigin($geneArray);
        $geneDto->homologueTaxon = (string)$geneArray['taxon_name'];
        $geneDto->symbol = (string)$geneArray['symbol'];
        $geneDto->ncbiId = (string)$geneArray['ncbi_id'];
        $geneDto->uniprot = (string)$geneArray['uniprot'];
        $geneDto->expressionChange = (int)$geneArray['expressionChange'];
        $geneDto->aliases = $geneArray['aliases'] ? explode(' ', $geneArray['aliases']) : [];
        $geneDto->functionalClusters = $this->mapFunctionalClusterDtos($geneArray['functional_clusters']);
        $geneDto->timestamp = $this->prepareTimestamp($geneArray);
        return $geneDto;
    }

    /**
     * @param string $geneFunctionalClustersString
     * @return FunctionalClusterDto[]
     */
    private function mapFunctionalClusterDtos($geneFunctionalClustersString): array
    {
        $functionalClusterDtos = [];
        if ($geneFunctionalClustersString) {
            $functionalClustersArray = explode(',', $geneFunctionalClustersString);
            foreach ($functionalClustersArray as $functionalCluster) {
                list($id, $name) = explode('|', $functionalCluster);
                $functionalClusterDto = new FunctionalClusterDto();
                $functionalClusterDto->id = (int)$id;
                $functionalClusterDto->name = $name;
                $functionalClusterDtos[] = $functionalClusterDto;
            }
        }

        return $functionalClusterDtos;
    }

    private function prepareOrthologs($orthologsString): array
    {
        $result = [];
        $orthologs = explode(';', $orthologsString);
        foreach ($orthologs as $orthologString) {
            if(strpos($orthologString, ',')) {
                list($organism, $ortholog) = explode(',', $orthologString);
                $result[$organism] = $ortholog;
            } else {
                $result[$orthologString] = '';
            }
        }
        return $result;
    }

    private function prepareOrigin($geneArray)
    {
        $phylum = new PhylumDto();
        $phylum->id = (int)$geneArray['phylum_id'];
        $phylum->age = $geneArray['phylum_age'];
        $phylum->phylum = $geneArray['phylum_name'];
        $phylum->order = (int)$geneArray['phylum_order'];
        return $phylum;
    }
    
    private function prepareTimestamp($geneArray): int {
        return (int)($geneArray['updated_at'] ?? $geneArray['created_at']);
    }

}