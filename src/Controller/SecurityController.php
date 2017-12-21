<?php
/**
 * Created by PhpStorm.
 * User: solr
 * Date: 21.12.2017
 * Time: 10:28
 */

namespace App\Controller;

use App\Form\RegistrationType;
use App\Security\RegistrationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     *
     * @param Request $request
     * @param RegistrationService $registrationService
     * @Route(path="/register", name="app_register")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(
                                    Request $request,
                                    RegistrationService $registrationService
    ){
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $registrationService->createUser($form->getData());
            $this->addFlash('success', 'Thanks for registering!');
            return $this->redirectToRoute('app_game');
        }

        return $this->render('register.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route(path="/login", name="app_signin")
     */
    public function signInAction(AuthenticationUtils $utils){
        return $this->render('signin.html.twig',
                            [
                                'last_username' => $utils->getLastUsername(),
                                'error' => null !== $utils->getLastAuthenticationError()
                            ]
        );
    }

    /**
     * @Route(path="/logout", name="app_signout")
     */
    public function signOutAction(){

    }
}