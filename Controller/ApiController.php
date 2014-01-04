<?php

namespace DCS\Form\SelectCityFormFieldBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ApiController extends Controller
{
    public function countriesListAction()
    {
        $this->checkSecurity();

        $data = $this->getEntityManager()->getRepository('DCSFormSelectCityFormFieldBundle:Country')->findAllToArray();
        return $this->serialize($data);
    }

    public function statesListAction($countryId)
    {
        $this->checkSecurity();
        $em = $this->getEntityManager();

        if (null === $country = $em->find('DCSFormSelectCityFormFieldBundle:Country', $countryId))
            throw new NotFoundHttpException('Country not found');

        $data = $em->getRepository('DCSFormSelectCityFormFieldBundle:State')->findAllToArray($countryId);
        return $this->serialize($data);
    }

    public function citiesListAction($stateId)
    {
        $this->checkSecurity();
        $em = $this->getEntityManager();

        if (null === $state = $em->find('DCSFormSelectCityFormFieldBundle:State', $stateId))
            throw new NotFoundHttpException('State not found');

        $data = $em->getRepository('DCSFormSelectCityFormFieldBundle:City')->findAllToArray($stateId);
        return $this->serialize($data);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->get('doctrine.orm.entity_manager');
    }

    /**
     * Check security role for api call
     *
     * @throws AccessDeniedHttpException
     */
    private function checkSecurity()
    {
        $role = $this->container->getParameter('dcs_form_select_city_form_field.api_security');

        if (!$this->get('security.context')->isGranted($role))
            throw new AccessDeniedHttpException('You cannot access to this resource');
    }

    /**
     * Serialize the array data to json Response
     * 
     * @param array $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function serialize(array $data)
    {
        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
