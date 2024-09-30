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

            $result = $client->writeTransaction(static function (TransactionInterface $tsx) {
                // Run your query
                $result = $tsx->run('MATCH (x) RETURN x');
                $nodesData = [];
                // Iterate over each record in the result
                foreach ($result as $record) {
                    // Get the node 'x'
                    $node = $record->get('x');
                    // Access node labels using getLabels()
                    $labels = $node->getLabels()->toArray();
                    // Get node properties (CypherMap)
                    $properties = $node->getProperties()->toArray();
                    // Collect the node data
                    $nodesData[] = [
                        'id' => $node->getId(),
                        'labels' => $labels,
                        'properties' => $properties,
                        'elementId' => $node->getElementId(),
                    ];
                }
            dd($nodesData);
                return $nodesData;
            });
            
           
            
            

        return $this->render('neo4j/index.html.twig', [
            'controller_name' => 'Neo4jController',
            //'result' => $result,
        ]);
    }
}
