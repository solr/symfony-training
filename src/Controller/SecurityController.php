<?php
/**
 * Created by PhpStorm.
 * User: solr
 * Date: 21.12.2017
 * Time: 10:28
 */

namespace App\Controller;

use App\Form\RegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route(path="/register", name="app_register")
     */
    public function registerAction(Request $request){
        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            dump($form->getData());
            return $this->redirectToRoute('app_game');
        }

        return $this->render('register.html.twig', ['form'=>$form->createView()]);
    }


}