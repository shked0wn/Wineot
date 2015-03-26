<?php

namespace Wineot\FrontEnd\SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\FrontEnd\SearchBundle\Form\Type\SearchType;


class SearchController extends Controller
{
    public function searchAction(Request $request)
    {
        $form = $this->createForm(new SearchType(), null, [
            'action' => $this->generateUrl('wineot_search_result'),
            'method' => 'POST']);

        return $this->render('WineotFrontEndSearchBundle:Search:Search.html.twig', array('form' => $form->createView()));
    }

    public function searchResultAction(Request $request)
    {
        $form = $this->createForm(new SearchType());

        $form->submit($request);
        if ($form->isValid()) {
            $searchInput = $form->getData()["searchInput"];
            $wineList = $this
                ->get('doctrine_mongodb')
                ->getManager()
                ->getRepository('WineotDataBundle:Wine')
                ->createQueryBuilder('q')
                ->where('q.name LIKE :searchInput')
                ->setParameter('searchInput', '%'.$searchInput.'%')
                ->getQuery()
                ->getResult();
//            if(!empty($wineList)){
                return $this->render('WineotFrontEndSearchBundle:Search:SearchResult.html.twig', array('wineList' => $wineList));
//            }
//            else{

//                 AUCUN RESULTATS
//            }
        }
    }
}