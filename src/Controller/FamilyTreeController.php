<?php

namespace App\Controller;


use App\Entity\FamilyTree;
use App\Entity\FamilyMember;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FamilyTreeController extends AbstractController
{
    #[Route('/family_tree', name: 'app_family_tree')]
    public function index(): Response
    {
        return $this->render('family_tree/index.html.twig', [
            'controller_name' => 'FamilyTreeController',
        ]);
    }
    
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getMembers(FamilyTree $familyTree): JsonResponse
    {
        $members = $this->entityManager->getRepository(FamilyMember::class)
                                       ->findBy(['family_tree' => $familyTree]);

        return new JsonResponse($members);
    }

    public function addMember(Request $request, FamilyTree $familyTree): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $member = new FamilyMember();
        $member->setFirstName($data['first_name']);
        $member->setLastName($data['last_name']);
        $member->setBirthDate(new \DateTimeImmutable($data['birth_date']));
        $member->setFamilyTree($familyTree);

        if (!empty($data['parent_1'])) {
            $parent1 = $this->entityManager->getRepository(FamilyMember::class)->find($data['parent_1']);
            $member->setParent1($parent1);
        }

        if (!empty($data['parent_2'])) {
            $parent2 = $this->entityManager->getRepository(FamilyMember::class)->find($data['parent_2']);
            $member->setParent2($parent2);
        }

        $this->entityManager->persist($member);
        $this->entityManager->flush();

        return new JsonResponse($member);
    }

    public function getDiagram(FamilyTree $familyTree): JsonResponse
    {
        $members = $this->entityManager->getRepository(FamilyMember::class)
                                       ->findBy(['family_tree' => $familyTree]);

        $diagramData = [];
        foreach ($members as $member) {
            $diagramData[] = [
                'id' => $member->getId(),
                'name' => $member->getFirstName() . ' ' . $member->getLastName(),
                'parent1' => $member->getParent1() ? $member->getParent1()->getId() : null,
                'parent2' => $member->getParent2() ? $member->getParent2()->getId() : null,
            ];
        }

        return new JsonResponse($diagramData);
    }









    
}
