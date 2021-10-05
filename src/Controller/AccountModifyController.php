<?php

namespace App\Controller;


use App\Form\ModifyTypePhpType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class AccountModifyController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    // Cette route donne Accés a ! 

    /**
     * @Route("/account/modify", name="modify")
     */

    // Ceci ! 
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response

    {

        $user = $this->getUser();
        $form = $this->createForm(ModifyTypePhpType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récuperer l'ancien mots de passe 
            $oldpass = $form->get("old_password")->getData();
            // verifier si le champ de l'ancien mot de passe et remplis 
            if (!empty($oldpass)) {
            // Vérifier si le champ le mot de passe user et le champ de l'input corresponde
                if ($hasher->isPassWordValid($user,$oldpass)) {
            // Assignation du nouveau mots de passe a $password 
                    $password = $hasher->hashPassword($user,$form->get("new_password")->getData());
            // Modifier le Password dans Entity/user par la valeur du champs 
                    $user->setPassword($password);
            // Préparation de la requête 
                    $this->entityManager->persist($user);
            // Execution de la requête 
                    $this->entityManager->flush();
                }
            }
            
        }

        return $this->render('account/modify.html.twig', [
            'form' => $form->createView(),
            // 'user' => dd($user)
        ]);
    }
}
