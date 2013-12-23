<?php

namespace EuroLiterie\structureBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EuroLiterie\structureBundle\Entity\HoraireRepo;
use Yomaah\structureBundle\Entity\MyMail;

class MainController extends Controller
{
    public function indexAction()
    {
        
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:index.html.twig');
    }

    public function accueilAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('accueil',1);
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:accueil.html.twig',
            array('position' => 'Accueil','articles' => $articles));
    }

    public function marquesAction()
    {
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('marques',1);
        $marques = $this->getDoctrine()->getRepository('EuroLiteriestructureBundle:Marque')->findAll();
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:marques.html.twig',
            array('position' => 'Nos Marques', 'articles' => $articles, 'marques' => $marques));
    }

    public function magasinAction()
    {
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:magasin.html.twig',array('position' => 'Notre magasin'));
    }

    public function contactAction()
    {
        $mail =  new MyMail();
        $form = $this->getForm($mail);
        $request = $this->get('request');
        $envoi = false;
        if ($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $m = $mail->getSwiftMailer();
                $this->get('mailer')->send($m); 
                $mail =  new MyMail();
                $form = $this->getForm($mail);
                $this->get('session')->set('envoie', true);
                return $this->redirect($this->generateUrl('literie_contact'));
            }
        }
        $this->get('session')->set('envoie', false);
        $h = new HoraireRepo();
        $horaires = $h->getHoraires();
        $articles = $this->getDoctrine()->getRepository('yomaahBundle:Article')->findByPage('contact', 1);
        return $this->get('templating')->renderResponse('EuroLiteriestructureBundle:Main:contact.html.twig', 
            array('position' => 'Nous trouver', 'horaires' =>$horaires, 'articles' => $articles,'form' => $form->createView()));
    }

    private function getForm($mail)
    {
        $formBuilder = $this->createFormBuilder($mail);
        $formBuilder->add('Objet','text',array('attr' => array ('placeholder' => 'L\'objet de votre message'),'label' => 'Sujet de votre message :'))
                    ->add('From','text',array('attr' => array ('placeholder' => 'Votre adresse email'),'label' => 'Votre email :'))
                    ->add('Message','textarea',array('attr' => array ('placeholder' => 'Votre message ...'),'label' => 'Votre message :'));
        return $formBuilder->getForm();
    }
    /**
     * Remplace fonction de login
     * de Yomaah\connexionBundle
     **/
    public function adminAction()
    {
        $this->get('session')->set('zoneAdmin', true);
        return $this->redirect($this->generateUrl('admin_literie_accueil'),301);
    }
    public function decoadminAction()
    {
        $this->get('session')->remove('zoneAdmin');
        return $this->redirect($this->generateUrl('admin_literie_accueil'),301);
    }
}
