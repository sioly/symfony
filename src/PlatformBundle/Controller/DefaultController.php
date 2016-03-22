<?php

namespace PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PlatformBundle\Entity\Project;
use PlatformBundle\Entity\SubProject;
use PlatformBundle\Entity\Users;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DefaultController extends Controller
{
    public function indexAction()
    {
    	//Récupération de l'entity Project
    	$project = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('PlatformBundle:Project')
		;
		$listProjects = $project->findAll();


        return $this->render('PlatformBundle:Default:index.html.twig', array('listProjects' => $listProjects));
    }

    public function projectAction(Request $request, $id)
    {
    	if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	//Création du formulaire permettant de créer un sous-projet.
    	$subproject = new SubProject();
    	$subproject->setIdProject($id);
    	$subproject->setIdAuthor($user->GetId());
	    $form = $this->createFormBuilder($subproject)
	        ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Valider'))
	        ->getForm();

	    //Validation du formulaire
	    $form->handleRequest($request);
	    if ($form->isSubmitted() && $form->isValid()) {
	    	$em = $this->getDoctrine()->getManager();
	      	$em->persist($subproject);
	      	$em->flush();
	      	$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
	        return $this->redirectToRoute('homepage');
	    }

	    //Récupération de l'entity Project
    	$project = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('PlatformBundle:Project')
		;
		$listProjects = $project->findAll();

		//Récupération de l'entity SubProject
		$subproject = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('PlatformBundle:SubProject')
		;
		$listSubProjects = $subproject->findAll();

		//Récupération de l'entity user
		$User = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('AppBundle:User')
		;
		$listUser = $User->findAll();

		//Récupération de l'entity users
		$Users = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('PlatformBundle:Users')
		;
		$listUsers = $Users->findAll();

        return $this->render('PlatformBundle:Default:project.html.twig', array('listUsers' => $listUsers, 'listUser' => $listUser, 'listProjects' => $listProjects, 'listSubProjects' => $listSubProjects, 'form' => $form->createView(), 'id' =>$id, 'user' => $user));
    
        } else {
			return $this->render('PlatformBundle:Default:index.html.twig');
		}
    }

    public function myProjectsAction(){
    	$user = $this->get('security.token_storage')->getToken()->getUser();

    	//Récupération de l'entity project
		$Project = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('PlatformBundle:Project')
		;
		$listProjects = $Project->findAll();
		 return $this->render('PlatformBundle:Default:myprojects.html.twig', array('listProjects' => $listProjects, 'user' => $user));
    }

    public function subprojectAction(Request $request, $id)
    {
    	if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

    	$user = $this->get('security.token_storage')->getToken()->getUser();
    	//Récupération de l'entity SubProject
    	$subproject = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('PlatformBundle:SubProject');

		$listSubProjects = $subproject->findAll();

		//Récupération de l'entity user
		$User = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('AppBundle:User')
		;
		$listUser = $User->findAll();

		//Récupération de l'entity users
		$Users = $this
		  ->getDoctrine()
		  ->getManager()
		  ->getRepository('PlatformBundle:Users')
		;
		$listUsers = $Users->findAll();

        return $this->render('PlatformBundle:Default:subproject.html.twig', array('listUsers' => $listUsers,'listUser' => $listUser, 'listSubProjects' => $listSubProjects, 'id' => $id, 'user' => $user));
    
        } else {
			return $this->render('PlatformBundle:Default:index.html.twig');
		}

    }

    public function addprojectAction(Request $request)
  	{
  		$user = $this->get('security.token_storage')->getToken()->getUser();
  		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

  		//Création du formulaire permettant de créer un projet.
	    $project = new Project();
	    $project->setIdAuthor($user->GetId());
	    $form = $this->createFormBuilder($project)
	        ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Valider le formulaire'))
	        ->getForm();

	    //Validation du formulaire
	    $form->handleRequest($request);
	    if ($form->isSubmitted() && $form->isValid()) {
	    	$em = $this->getDoctrine()->getManager();
	      	$em->persist($project);
	      	$em->flush();
	        return $this->redirect($this->generateUrl('platform_project', array('id' => $project->getId())));
	    }

	    return $this->render('PlatformBundle:Default:addproject.html.twig', array(
	        'form' => $form->createView(),
	    ));

		} else {
			return $this->render('PlatformBundle:Default:index.html.twig');
		}
  	}

  	public function editProjectAction($id, Request $request)
  	{
  		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

	    $em = $this->getDoctrine()->getManager();
	    $advert = $em->getRepository('PlatformBundle:Project')->find($id);
	 
	    if ($advert == null) {
	      throw $this->createNotFoundException("Nothing found");
	    }
	 	
	    //Création du formulaire permettant d'update un projet.
	    $updateform = $this->createFormBuilder($advert)
	        ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Updater le formulaire'))
	        ->getForm();

	    $updateform->handleRequest($request);
	    if ($updateform->isSubmitted() && $updateform->isValid()) {
	    	$edit = $updateform->getData();
        	$em->persist($edit);
        	$em->flush();
	        return $this->redirect($this->generateUrl('platform_project', array('id' => $advert->getId())));
	    }

    	return $this->render('PlatformBundle:Default:editproject.html.twig', array(
	    	'form' => $updateform->createView(),
	    ));

    	} else {
    		return $this->render('PlatformBundle:Default:index.html.twig');
    	}
  	}
 
  	public function deleteProjectAction($id)
  	{
	    $em = $this->getDoctrine()->getManager();
	    $advert = $em->getRepository('PlatformBundle:Project')->find($id);
	 
	    if ($advert == null) {
	      throw $this->createNotFoundException("Nothing found");
	    }
	 	 
	    $em->remove($advert);
    	$em->flush();

        $this->addFlash(
            'notice',
            'Le projet a bien été supprimé!'
        );

    	return $this->redirectToRoute('homepage');
  	}

  	public function editSubProjectAction($id, Request $request)
  	{
  		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

	    $em = $this->getDoctrine()->getManager();
	    $advert = $em->getRepository('PlatformBundle:SubProject')->find($id);
	 
	    if ($advert == null) {
	      throw $this->createNotFoundException("Nothing found");
	    }
	 	
	    //Création du formulaire permettant d'update un projet.
	    $updateform = $this->createFormBuilder($advert)
	        ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Updater le formulaire'))
	        ->getForm();

	    $updateform->handleRequest($request);
	    if ($updateform->isSubmitted() && $updateform->isValid()) {
	    	$edit = $updateform->getData();
        	$em->persist($edit);
        	$em->flush();
	        return $this->redirect($this->generateUrl('platform_subproject', array('id' => $advert->getId())));
	    }

    	 return $this->render('PlatformBundle:Default:editsubproject.html.twig', array(
	        'form' => $updateform->createView(),
	    ));

    	} else {
    		return $this->render('PlatformBundle:Default:index.html.twig');
    	}
  	}

  	public function deleteSubProjectAction($id)
  	{
        $em = $this->getDoctrine()->getManager();
	    $advert = $em->getRepository('PlatformBundle:SubProject')->find($id);
	 
	    if ($advert == null) {
	      throw $this->createNotFoundException("Nothing found");
	    }
	 	 
	    $em->remove($advert);
    	$em->flush();

        $this->addFlash(
            'notice',
            'Le sous-projet a bien été supprimé!'
        );

    	return $this->redirectToRoute('homepage');
  	}

  	public function deleteUsersAction($id)
      	{
            $em = $this->getDoctrine()->getManager();
    	    $advert = $em->getRepository('PlatformBundle:Users')->find($id);

    	    if ($advert == null) {
    	      throw $this->createNotFoundException("Nothing found");
    	    }

    	    $em->remove($advert);
        	$em->flush();

            $this->addFlash(
                'notice',
                'L\'utilisateur a bien été supprimé du projet!'
            );

        	return $this->redirectToRoute('homepage');
      	}

  	public function addUserProjectAction(Request $request, $idProject, $idUser){
  		$add = New Users();
  		$add->setIdUser($idUser);
  		$add->setIdProject($idProject);
  		$add->setIdSubProject(0);
  		$em = $this->getDoctrine()->getManager();
	    $advert = $em->getRepository('PlatformBundle:Users');
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($add);
	    $em->flush();

	    $this->addFlash(
            'notice',
            'L\'utilisateur a bien été ajouté au projet!'
        );

	    return $this->redirectToRoute('homepage');
  	}

  	public function addUserSubProjectAction(Request $request, $idSubProject, $idUser){
  		$add = New Users();
  		$add->setIdUser($idUser);
  		$add->setIdSubProject($idSubProject);
  		$add->setIdProject(0);
  		$em = $this->getDoctrine()->getManager();
	    $advert = $em->getRepository('PlatformBundle:Users');
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($add);
	    $em->flush();

	    $this->addFlash(
            'notice',
            'L\'utilisateur a bien été ajouté au sous-projet!'
        );

	    return $this->redirectToRoute('homepage');
  	}

}