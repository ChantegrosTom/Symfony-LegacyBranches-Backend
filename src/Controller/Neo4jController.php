<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Service\Neo4jService;


use Laudis\Neo4j\Contracts\TransactionInterface;

class Neo4jController extends AbstractController
{
    private Neo4jService $neo4jService;

    public function __construct(Neo4jService $neo4jService)
    {
        $this->neo4jService = $neo4jService;
    }
    
    
    #[Route('/neo4j', name: 'app_neo4j')]
    public function index(): Response
    {

        $client = $this->neo4jService->neo4jBdd();


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
