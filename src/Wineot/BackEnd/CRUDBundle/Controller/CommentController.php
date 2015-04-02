<?php
/**
 * User: floran
 * Date: 02/04/15
 * Time: 06:04
 */

namespace Wineot\BackEnd\CRUDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function indexAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $comments = $dm->getRepository('WineotDataBundle:Comment')->findAll();
        $paramsRender = array('comments' => $comments);
        return $this->render('WineotBackEndCRUDBundle:Comment:index.html.twig', $paramsRender);
    }

    public function deleteAction($id)
    {
        $flash = $this->get('notify_messenger.flash');
        $dm = $this->get('doctrine_mongodb')->getManager();
        $comment = $dm->getRepository('WineotDataBundle:Comment')->find($id);
        if ($comment) {
            $dm->remove($comment);
            $dm->flush();

            $flash->success($this->get('translator')->trans('crud.warn.comment.deleted'));
        } else {
            $flash->error($this->get('translator')->trans('crud.error.comment.notfound'));
        }
        return $this->redirectToRoute('wineot_back_end_crud_comment');
    }
} 