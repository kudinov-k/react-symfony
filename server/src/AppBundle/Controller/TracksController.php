<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class TracksController extends FOSRestController
{
    /**
     * @Rest\Post("/tracks")
     *
     * @param $request Request
     *
     * @return mixed
     */
    public function postAction(Request $request)
    {
        $page = $request->get('page');
        $limit = $request->get('pageSize', 10);
        $sorted = $request->get('sorted');
        $filtered = $request->get('filtered');
        $result = $this->getDoctrine()->getRepository('AppBundle:Track')
            ->getAllTracks($page, $limit, $sorted, $filtered);
        if ($result === null) {
            return new View("No tracks", Response::HTTP_NOT_FOUND);
        }

        $pages = ceil($result->count() / $limit);

        return ['tracks' => $result->getIterator()->getArrayCopy(), 'pages' => $pages];
    }
}