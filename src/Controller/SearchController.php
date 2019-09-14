<?php


namespace App\Controller;



use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @param Request $request
     * @param SearchService $searchService
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/user-search", name="search")
     */

    public function searchUser(Request $request, SearchService $searchService) {

        $search = $request->get('search');

        return $this->render('user/listing.html.twig', ['users' => $searchService->searchUser($search)]);
    }

    /**
     * @param Request $request
     * @param SearchService $searchService
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/search-address", name="search_address")
     */

    public function searchAddress(Request $request, SearchService $searchService) {

        $search = $request->get('search');

        return $this->render('user/addresses.html.twig', ['address' => $searchService->searchAddress($search)]);
    }

    /**
     * @param Request $request
     * @param SearchService $searchService
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/advanced-user-search-result", name="asearch_user_result")
     */

    public function advancedUserSearch(Request $request, SearchService $searchService) {

        $criteria = [
            'name' => $request->get('name'),
            'surname' => $request->get('surname')
        ];
        return $this->render('user/listing.html.twig', ['users' => $searchService->advancedUserSearch($criteria)]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/advanced-user-search", name="asearch_user")
     */


}