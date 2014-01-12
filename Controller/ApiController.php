<?php

namespace DCS\Form\SelectCityFormFieldBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Doctrine\ORM\AbstractQuery;

class ApiController extends Controller
{
    public function countriesListAction()
    {
        $this->checkSecurity();

        $data = $this->get('dcs_select_city_form_field.manager.country')->findAll(AbstractQuery::HYDRATE_ARRAY);
        return $this->serialize($data);
    }

    public function regionsListAction($countryId)
    {
        $this->checkSecurity();

        if (null === $country = $this->get('dcs_select_city_form_field.manager.country')->find($countryId))
            throw new NotFoundHttpException('Country not found');

        $data = $this->get('dcs_select_city_form_field.manager.region')->findAllByCountryId($countryId, AbstractQuery::HYDRATE_ARRAY);
        return $this->serialize($data);
    }

    public function citiesListAction($regionId)
    {
        $this->checkSecurity();

        if (null === $region = $this->get('dcs_select_city_form_field.manager.region')->find($regionId))
            throw new NotFoundHttpException('Region not found');

        $data = $this->get('dcs_select_city_form_field.manager.city')->findAllByRegionId($regionId, AbstractQuery::HYDRATE_ARRAY);
        return $this->serialize($data);
    }

    /**
     * Check security role for api call
     *
     * @throws AccessDeniedHttpException
     */
    private function checkSecurity()
    {
        $role = $this->container->getParameter('dcs_select_city_form_field.api_security');
        $securityContext = $this->get('security.context');
        $token = $securityContext->getToken();

        if (null === $token && 'IS_AUTHENTICATED_ANONYMOUSLY' != $role)
            throw new AccessDeniedHttpException('You cannot access to this resource');

        if (null !== $token && !$securityContext->isGranted($role))
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
