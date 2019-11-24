<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\CommentForum;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Commentforum controller.
 *
 */
class CommentForumController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentForums = $em->getRepository('ForumBundle:CommentForum')->findAll();

        return $this->render('commentforum/index.html.twig', array(
            'commentForums' => $commentForums,
        ));
    }

    /**
     * Creates a new commentForum entity.
     *
     */
    public function newAction(Request $request)
    {
        $commentForum = new Commentforum();
        $form = $this->createForm('ForumBundle\Form\CommentForumType', $commentForum);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentForum);
            $em->flush();

            return $this->redirectToRoute('comment_show', array('id' => $commentForum->getId()));
        }

        return $this->render('commentforum/new.html.twig', array(
            'commentForum' => $commentForum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentForum entity.
     *
     */
    public function showAction(CommentForum $commentForum)
    {
        $deleteForm = $this->createDeleteForm($commentForum);

        return $this->render('commentforum/show.html.twig', array(
            'commentForum' => $commentForum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentForum entity.
     *
     */
    public function editAction(Request $request, CommentForum $commentForum)
    {
        $deleteForm = $this->createDeleteForm($commentForum);
        $editForm = $this->createForm('ForumBundle\Form\CommentForumType', $commentForum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $commentForum->getId()));
        }

        return $this->render('commentforum/edit.html.twig', array(
            'commentForum' => $commentForum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentForum entity.
     *
     */
    public function deleteAction(Request $request, CommentForum $commentForum)
    {
        $form = $this->createDeleteForm($commentForum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentForum);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a commentForum entity.
     *
     * @param CommentForum $commentForum The commentForum entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommentForum $commentForum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $commentForum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
