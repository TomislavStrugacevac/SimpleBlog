<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Blog;
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
        return $this->render('blog/create.html.twig');
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
        return $this->render('blog/details.html.twig');
    }

}
