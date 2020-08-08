<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Services\FileService;

/**
 * @Route("/article", name="article.")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request, ValidatorInterface $validator, FileService $fileService)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        $image = '3faa89e6e7888dcaf7ef766357fc021d.png';

        if ($form->isSubmitted()){

            $errors = $validator->validate($article);

            if (count($errors) > 0){

                $this->addFlash('warning','The data is invalid. Enter correct data.');

                return $this->redirect($this->generateUrl('article.create'));
            }
            else{

                $file = $request->files->get('article')["my_file"];
                $fileService->uploadFile($file);

//                $uploads_directory = $this->getParameter('uploads_directory');
//                $filename = md5(uniqid()) . '.' . $file->guessExtension();
//                $file->move(
//                    $uploads_directory,
//                    $filename
//                );



//                $article->setAuthor('Kacper');
//                $article->setInsertdate();
//
//                $em = $this->getDoctrine()->getManager();
//                $em->persist($article);
//                $em->flush();
//
//                $this->addFlash('success', 'Article was added.');
//                return $this->redirect($this->generateUrl('article.index'));

            }
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView(),
            'image' => $image
        ]);
    }

    //Read

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(ArticleRepository $articleRepository, $id)
    {
        $article = $articleRepository->findOneBy(array(
            'id' => $id
        ));
//        $articleTitle = $article->getTitle();

        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    //Update

    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request, ArticleRepository $articleRepository, ValidatorInterface $validator, $id)
    {
        $article = $articleRepository->findOneBy(array(
            'id' => $id
        ));

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted()){

            $errors = $validator->validate($article);

            if (count($errors) > 0){

                $this->addFlash('warning','The data is invalid. Enter correct data.');

                return $this->redirect($this->generateUrl('article.update', ['id' => $id]));
            }
            else{

                $article->setAuthor('Kacper');
                $article->setInsertdate();

                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                $this->addFlash('success', 'Article was updated.');
                return $this->redirect($this->generateUrl('article.index'));

            }
        }

        return $this->render("article/update.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        $this->addFlash('success', 'Article has been deleted.');

        return $this->redirect($this->generateUrl('article.index'));
    }
}
