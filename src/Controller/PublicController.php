<?php

namespace App\Controller;
use App\Entity\News;
use App\Repository\NewsRepository;

use App\Entity\Tags;
use App\Repository\TagsRepository;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;

use App\Entity\Comments;
use App\Form\PublicCommentsType;
use App\Repository\CommentsRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PublicController extends AbstractController
{
    /**
     * @Route("/", name="public")
     */
    public function index(NewsRepository $newsRepository, CategoriesRepository $catRepository, TagsRepository $tagsRepository)
    {
        return $this->render('public/index.html.twig', [
            'news' => $newsRepository->findAll(),
            'categories' => $catRepository->findAll(),
            'tags' => $tagsRepository->findAll(),
        ]);

    }
    /**
     * @Route("/{category}", name="public-bycat")
     */
    public function showByCategory($category, NewsRepository $newsRepository, CategoriesRepository $catRepository, TagsRepository $tagsRepository) {
      return $this->render('public/index.html.twig', [
          'currentCategory' => $catRepository->findOneBy(["id" => $category]),
          'news' => $newsRepository->findByCat($category),
          'categories' => $catRepository->findAll(),
          'tags' => $tagsRepository->findAll(),
      ]);
    }

    /**
     * @Route("/article/{id}", name="article")
     */
     public function showArticle(Request $request, $id, NewsRepository $newsRepository, CategoriesRepository $catRepository, TagsRepository $tagsRepository, CommentsRepository $comRepository) {
       $comment = new Comments();
       $comment->setNews($newsRepository->findOneBy(["id" => $id]));
       $form = $this->createForm(PublicCommentsType::class, $comment);
       dump($request);
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($comment);
           $entityManager->flush();
       }
       dump($newsRepository->findOneBy(["id" => $id])->getTags());
       return $this->render('public/article.html.twig', [
           'currentCategory' => $catRepository->findOneBy(["id" => $id]),
           'comments' => $comRepository->findBy(["news" => $id]),
           'article' => $newsRepository->findOneBy(["id" => $id]),
           'tags' => $newsRepository->findOneBy(["id" => $id])->getTags(),
           'form' => $form->createView(),
       ]);
     }

}
