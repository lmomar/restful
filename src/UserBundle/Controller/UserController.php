<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use UserBundle\Form\UserType;
use UserBundle\Entity\User;


class UserController extends Controller   {

    /**
     * @Rest\View()
     * @Rest\Get("/user/{id}")
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserAction(Request $request) {
        $user = $this->getDoctrine()
                ->getRepository("UserBundle:User")
                ->find($request->get('id'));

        if (empty($user)) {
            return new JsonResponse(['message' => 'user not fount'], Response::HTTP_NOT_FOUND);
        }

        return $user;
//return new JsonResponse($formated);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/users")
     */
    public function getUsersAction(Request $request) {
        $users = $this->get('doctrine.orm.entity_manager')
                ->getRepository('UserBundle:User')
                ->findAll();

        return $users;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/adduser")
     */
    public function postUserAction(Request $request) {
        $user = new User();
         $form = $this->createForm(UserType::class, $user);
        $form->submit($request->request->all());
        
        if ($form->isValid()) {
            //$user = $form->getData();
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
            
        } else {
            return $form;
        }
    }

}
