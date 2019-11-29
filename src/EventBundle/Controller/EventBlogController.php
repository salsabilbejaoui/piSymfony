<?php

namespace EventBundle\Controller;

use EventBundle\Entity\EventBlog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Eventblog controller.
 *
 */
class EventBlogController extends Controller
{
    /**
     * Lists all eventBlog entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eventBlogs = $em->getRepository('EventBundle:EventBlog')->findAll();

        return $this->render('eventblog/index.html.twig', array(
            'eventBlogs' => $eventBlogs,
        ));
    }

    /**
     * Creates a new eventBlog entity.
     *
     */
    public function newAction(Request $request)
    {
        $eventBlog = new Eventblog();
        $form = $this->createForm('EventBundle\Form\EventBlogType', $eventBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventBlog);
            $em->flush();

            return $this->redirectToRoute('event_show', array('id' => $eventBlog->getId()));
        }

        return $this->render('eventblog/new.html.twig', array(
            'eventBlog' => $eventBlog,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a eventBlog entity.
     *
     */
    public function showAction(EventBlog $eventBlog)
    {
        $deleteForm = $this->createDeleteForm($eventBlog);

        return $this->render('eventblog/show.html.twig', array(
            'eventBlog' => $eventBlog,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing eventBlog entity.
     *
     */
    public function editAction(Request $request, EventBlog $eventBlog)
    {
        $deleteForm = $this->createDeleteForm($eventBlog);
        $editForm = $this->createForm('EventBundle\Form\EventBlogType', $eventBlog);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_edit', array('id' => $eventBlog->getId()));
        }

        return $this->render('eventblog/edit.html.twig', array(
            'eventBlog' => $eventBlog,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a eventBlog entity.
     *
     */
    public function deleteAction(Request $request, EventBlog $eventBlog)
    {
        $form = $this->createDeleteForm($eventBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($eventBlog);
            $em->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * Creates a form to delete a eventBlog entity.
     *
     * @param EventBlog $eventBlog The eventBlog entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(EventBlog $eventBlog)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $eventBlog->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
