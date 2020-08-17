<?php

namespace App\Service;

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

    /**
     * @param SearchUserInterface    $searchUserInterface
     * @param SearchAddressInterface $searchAddressInterface
     */
    public function __construct(SearchUserInterface $searchUserInterface, SearchAddressInterface $searchAddressInterface)
    {
        $this->searchUserInterface = $searchUserInterface;
        $this->searchAddressInterface = $searchAddressInterface;
    }

    /**
     * @param $search
     *
     * @return mixed
     */
    public function searchUser($search)
    {
        return $this->searchUserInterface->findUser($search);
    }

    /**
     * @param $search
     *
     * @return mixed
     */
    public function searchAddress($search)
    {
        return $this->searchAddressInterface->findAddress($search);
    }

    /**
     * @param array $criteria
     *
     * @return mixed
     */
    public function advancedUserSearch(array $criteria)
    {
        return $this->searchUserInterface->advancedFindUser($criteria);
    }

    /**
     * @param array $criteria
     *
     * @return mixed
     */
    public function advancedAddressSearch(array $criteria)
    {
        return $this->searchAddressInterface->advancedFindAddress($criteria);
    }
}