<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SimpleBlogController extends Controller
{
    /**
     * @Route("/blog/index", name="blog_index")
     */
    public function indexAction(Request $request)
    {
        $blogs = $this->getDoctrine()
            ->getRepository('AppBundle:Blog')
            ->findAll();

        return $this->render('blog/index.html.twig', [
            'blogs' => $blogs
        ]);
    }

    /**
     * @Route("/blog/create", name="blog_create")
     */
    public function createAction(Request $request)
    {
        $blog = new Blog;
        $form = $this->createFormBuilder($blog)
        -> add( 'title', TextType::class, [
                            'attr' => [
                                'class' => 'form-control',
                                'style' => 'margin-bottom:15px'
           ]])
        -> add( 'body', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]])
        -> add( 'createdBy', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'margin-bottom:15px'
                ]])
        -> add( 'submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn.md',
                    'label' => 'Submit New Blog Entry'
                ]])
        ->getForm();

        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() ){
            $title = $form['title']->getData();
            $body = $form['body']->getData();
            $createdBy = $form['createdBy']->getData();
            $timeCreated = new\DateTime('now');

            $blog->setTitle($title);
            $blog->setBody($body);
            $blog->setCreatedBy($createdBy);
            $blog->setTimeCreated($timeCreated);

            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash(
                'notice', 'New Blog Added'
            );

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('blog/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/blog/edit/{id}", name="blog_edit")
     */
    public function editAction($id, Request $request)
    {
        return $this->render('blog/edit.html.twig');
    }

    /**
     * @Route("/blog/details/{id}", name="blog_list")
     */
    public function detailsAction($id)
    {
        $blog = $this->getDoctrine()
            ->getRepository('AppBundle:Blog')
            ->find($id);
        return $this->render('blog/details.html.twig', [
            'blog' => $blog
        ]);
    }

}
