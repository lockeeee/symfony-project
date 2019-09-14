<?php


namespace App\Service\Search;


interface SearchUserInterface
{
    public function findUser($search);
    public function advancedFindUser(array $criteria);
}