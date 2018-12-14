<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tags;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Utils\Database;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $db = Database::getInstance();
        $mysqli = $db->getConnection();
        $sql_query = "Select * from esync_tags";
        $result = $mysqli->query($sql_query);
        $em = $this->getDoctrine()->getManager();


        //$tag = new Tags();
        //$tag->setUserList()

        // $tags = [];
        while ($results = $result->fetch_assoc()){
            // $tags[]=$results;
            $product = $em->getRepository(Tags::class)->find($results["Id"]);
            $product->setValeur($results["Val"]);
            $em->flush();
        }

        $twig = $em->getRepository(Tags::class)->findAll();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'tags' => $twig,
        ]);
    }
}
