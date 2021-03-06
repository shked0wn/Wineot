<?php
/**
 * User: floran
 * Date: 29/03/15
 * Time: 16:34
 */

namespace Wineot\BackEnd\CRUDBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Wineot\DataBundle\Document\Vintage;
use Wineot\DataBundle\Document\Wine;
use Wineot\DataBundle\Form\WineType;

class WineController extends Controller
{
    public function indexAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wines = $dm->getRepository('WineotDataBundle:Wine')->findAll();
        $paramsRender = array('wines' => $wines);
        return $this->render('WineotBackEndCRUDBundle:Wine:index.html.twig', $paramsRender);
    }

    public function addAction(Request $request)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = new Wine();
        $form = $this->createForm(new WineType(), $wine);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.added'));
            return $this->redirectToRoute('wineot_back_end_crud_wine');
        }

        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotBackEndCRUDBundle:Wine:add.html.twig', $paramsRender);
    }

    public function editAction(Request $request, $id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($id);
        if (!$wine) {
            $flash->error($this->get('translator')->trans('crud.error.wine.notfound'));
            return $this->redirectToRoute('wineot_back_end_crud_wine');
        }

        $originalVintages = new ArrayCollection();
        foreach ($wine->getVintages() as $vintage) {
            $originalVintages->add($vintage);
        }

        $originalGrappes = new ArrayCollection();
        foreach ($wine->getGrappes() as $grappe) {
            $originalGrappes->add($grappe);
        }

        $form = $this->createForm(new WineType(), $wine);
        $form->handleRequest($request);
        if ($form->isValid()) {

            foreach ($originalVintages as $vintage) {
                if ($wine->getVintages()->contains($vintage) == false) {
                    $dm->remove($vintage);
                }
            }
            foreach ($originalGrappes as $grappe) {
                if ($wine->getGrappes()->contains($grappe) == false) {
                    $dm->remove($grappe);
                }
            }
            $dm->persist($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.edited'));
            return $this->redirectToRoute('wineot_back_end_crud_wine');
        }
        $paramsRender = array('form' => $form->createView());
        return $this->render('WineotBackEndCRUDBundle:Wine:edit.html.twig', $paramsRender);
    }

    public function deleteAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($id);
        if ($wine) {
            $wine->getWinery()->removeWine($wine);
            $dm->remove($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.wine.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_wine');
    }

    public function deletePictureAction(Request $request, $id, $pictureId)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $wine = $dm->getRepository('WineotDataBundle:Wine')->find($id);
        if (!$wine)
            $wine = $dm->getRepository('WineotDataBundle:Vintage')->find($id);
        $picture = $dm->getRepository('WineotDataBundle:Image')->find($pictureId);
        if ($wine) {
            $dm->remove($picture);
            $wine->removePicture($picture);
            $dm->persist($wine);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.wine.picture.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.wine.notfound'));
        }
        return $this->redirect($request->headers->get('referer'));
    }
} 