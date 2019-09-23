<?php


namespace App\Service;


use App\Controller\SearchController;
use App\Service\Search\SearchAddressInterface;
use App\Service\Search\SearchUserInterface;

class SearchService
{

    /**
     * @var SearchUserInterface
     */
    private $searchUserInterface;

    /**
     * @var SearchAddressInterface
     */
    private $searchAddressInterface;

    public function searchUser($search) {
        return $this->searchUserInterface->findUser($search);
    }

    public function searchAddress($search) {
        return $this->searchAddressInterface->findAddress($search);
    }

    public function advancedUserSearch(array $criteria) {
        return $this->searchUserInterface->advancedFindUser($criteria);
    }

    public function advancedAddressSearch(array $criteria) {
        return $this->searchAddressInterface->advancedFindAddress($criteria);
    }

    public function __construct(SearchUserInterface $searchUserInterface, SearchAddressInterface $searchAddressInterface)
    {
        $this->searchUserInterface = $searchUserInterface;
        $this->searchAddressInterface = $searchAddressInterface;
    }
}