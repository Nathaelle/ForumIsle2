<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\UserRepository;
use App\Repository\SubjectRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @ParamConverter("createdAt", class="DateTimeImmutable")
     */
    public function index(UserRepository $usrepo, SubjectRepository $repo, Request $request, ObjectManager $manager): Response
    {
        $datas = $repo->findAll();
        $subject = new Subject();

        // #2 J'instancie un formulaire à partir d'un modèle (créé précédemment via la commande make:form)
        $form = $this->createForm(SubjectType::class, $subject);

        //#3 Je lie mon formulaire aux données récupérées dans ma "requête" (objet type Request)
        $form->handleRequest($request);

        // Si le formulaire a été soumi et s'il est valide
        if($form->isSubmitted() && $form->isValid()) {

            // Je renseigne ma propriété user (manquante)
            // Normalement avec l'utilisateur connecté ($this->getUser())
            $subject->setUser($usrepo->find(2));

            // J'ajoute à ma pile
            $manager->persist($subject);
            // J'envoie les données dans la base de données
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Page d\'accueil',
            'subjects' => $datas,
            'form' => $form->createView(), // J'envoie mon formulaire à la vue (Twig)
        ]);
    }

}
