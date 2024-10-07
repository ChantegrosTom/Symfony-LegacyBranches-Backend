<?php

namespace App\Service;

//use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Contracts\ClientInterface;

class Neo4jService
{

    public function neo4jBdd(): ClientInterface 
    {
        $client = ClientBuilder::create()
        ->withDriver('bolt', 'bolt://neo4j:password@neo4j')
        //->withDriver('https', 'https://test.com', Authenticate::basic('user', 'password'))
        //->withDriver('neo4j', 'neo4j://neo4j.test.com?database=my-database', Authenticate::oidc('token'))
        ->withDefaultDriver('bolt')
        ->build();

        return $client;
    }

}
