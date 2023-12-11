<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use App\Form\CategoryType;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/category', name:'category_')]
class CategoryController extends AbstractController
{
    //Display all categories on an index page
    #[Route('/', name:'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', ['categories' => $categories]);
    }

    //Add a new Category
    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        //Create a new Category object
        $category = new Category();
        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);
        //Get data from HTTP request
        $form->handleRequest($request);
        //Was the form submitted?
        if ($form->isSubmitted()) {
            $entityManager->persist($category);
            $entityManager->flush();

            //Redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        //Render the form
        return $this->render('category/new.html.twig', ['form' => $form]);
    }

    //Show one category
    #[Route('/{categoryName}',methods: ['GET'], name:'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        //Get the category name by its ID
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : '.$categoryName.' found in categories\' table.'
            );
        }
        
        $programs = $programRepository->findBy(['category' => $category], ['id' => 'DESC'], 3);

        return $this->render('category/show.html.twig', ['programs' => $programs, 'category' => $categoryName]);
    }
}