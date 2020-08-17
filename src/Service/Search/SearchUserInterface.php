<?php


namespace App\Service\Search;


interface SearchUserInterface
{
    /**
     * @param $search
     *
     * @return mixed
     */
    public function findUser($search);

    /**
     * @param array $criteria
     *
     * @return mixed
     */
    public function advancedFindUser(array $criteria);
}