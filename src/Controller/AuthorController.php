<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use App\Form\AuthorType;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);

    }

 #[Route('/list/{var}', name: 'list_author')]
    public function listAuthor($var)
{
    $authors = array(
        array('id' => 1, 'username' => ' Victor Hugo','email'=> 'victor.hugo@gmail.com', 'nb_books'=> 100),
        array ('id' => 2, 'username' => 'William Shakespeare','email'=>
            'william.shakespeare@gmail.com','nb_books' => 200),
        array('id' => 3, 'username' => ' Taha Hussein','email'=> 'taha.hussein@gmail.com','nb_books' => 300),
    );

    /** @var TYPE_NAME $this */
    return $this->render("author/list.html.twig",
        ['variable'=>$var,
            'tabAuthors'=>$authors
        ]);
}
    #[Route('/listAuthor', name: 'authors')]
    public function list(AuthorRepository $repository)
    {
        /** @var TYPE_NAME $repository */
        $authors = $repository->findAll();
        return $this->render("author/listAuthors.html.twig",
            array(
                'tabAuthors'=>$authors
            ));
    }
    #[Route('/showAll', name: 'showAll')]
    public function showAll(AuthorRepository $repo ){
        $list=$repo->findAll();
        return $this->render('author/showAll.html.twig',['Authors'=>$list]);
    }
    #[Route('/addAuthor', name: 'addAuthor')]
    public function addAuthor(Request $request, ManagerRegistry $manager)
    {
        $author = new Author();
        $form = $this->createForm(\App\Form\ListAuthorsType::class, $author);
        $form->add('add',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            $em = $manager->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('showAll');
        }
        return $this->render('author/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/deleteAuthor/{id}', name: 'detail_author')]
    public function deleteAuthor($id,AuthorRepository $arepo, ManagerRegistry $doctrine ): Response
    {
        $em=$doctrine->getManager();
        $author=$arepo->find($id);
        $em->remove($author);
        $em->flush();
        return new Response("supprime");
    }
    #[Route('/deleteAuthor/{id}', name: 'deleteAuthor')]
    public function delete($id,AuthorRepository $repo,ManagerRegistry $manager){
        $author=$repo->find($id);
        $em=$manager->getManager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('showAll');
    }
    #[Route('/updateAuth/{id}', name: 'updateAuth')]
    public function updateAuth($id,AuthorRepository $repo,ManagerRegistry $manager,Request $Request){
        $author=$repo->find($id);
        $form=$this->createForm(ListAuthorsType::class,$author);
        $form->add('update',SubmitType::class);
        $form->handleRequest($Request);

        if($form->isSubmitted()){
            $em=$manager->getManager();
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('showAll');
        }
        return $this->render('author/update.html.twig',['form'=>$form->createview()]);
    }

}
