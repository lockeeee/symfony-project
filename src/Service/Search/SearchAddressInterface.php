<?php


namespace App\Service\Search;


interface SearchAddressInterface
{
    /**
     * @param $search
     *
     * @return mixed
     */
    public function findAddress($search);
}