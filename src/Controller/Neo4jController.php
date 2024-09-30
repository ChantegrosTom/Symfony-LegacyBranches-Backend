<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;

use Laudis\Neo4j\Contracts\TransactionInterface;

class Neo4jController extends AbstractController
{
    #[Route('/neo4j', name: 'app_neo4j')]
    public function index(): Response
    {
        $client = ClientBuilder::create()
            ->withDriver('bolt', 'bolt://neo4j:password@neo4j')
            ->withDriver('https', 'https://test.com', Authenticate::basic('user', 'password'))
            ->withDriver('neo4j', 'neo4j://neo4j.test.com?database=my-database', Authenticate::oidc('token'))
            ->withDefaultDriver('bolt')
            ->build();

        //$result = $client->writeTransaction(static function (TransactionInterface $tsx) {
        //    $result = $tsx->run('MATCH (x) RETURN x');
        //    $records = $result->getRecords();
        //     return $records;
        //});

        return $this->render('neo4j/index.html.twig', [
            'controller_name' => 'Neo4jController',
            //'result' => $result,
        ]);
    }
}
