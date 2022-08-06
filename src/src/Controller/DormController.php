<?php

namespace App\Controller;

use App\Dorm\Search;
use App\Entity\Dorm;
use App\Form\DormType;
use App\Repository\DormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dorm')]
class DormController extends AbstractController
{
    #[Route('/', name: 'app_dorm_index', methods: ['GET'])]
    public function index(DormRepository $dormRepository): Response
    {
        return $this->render('dorm/index.html.twig', [
            'dorms' => $dormRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dorm_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DormRepository $dormRepository): Response
    {
        $dorm = new Dorm();
        $form = $this->createForm(DormType::class, $dorm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dormRepository->add($dorm, true);

            return $this->redirectToRoute('app_dorm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dorm/new.html.twig', [
            'dorm' => $dorm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dorm_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Dorm $dorm): Response
    {
        return $this->render('dorm/show.html.twig', [
            'dorm' => $dorm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dorm_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dorm $dorm, DormRepository $dormRepository): Response
    {
        $form = $this->createForm(DormType::class, $dorm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dormRepository->add($dorm, true);

            return $this->redirectToRoute('app_dorm_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dorm/edit.html.twig', [
            'dorm' => $dorm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dorm_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Dorm $dorm, DormRepository $dormRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dorm->getId(), $request->request->get('_token'))) {
            $dormRepository->remove($dorm, true);
        }

        return $this->redirectToRoute('app_dorm_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/search', name: 'app_hotel_search', methods: ['GET'])]
    //#[ParamConverter('GET', class: 'SearchHotel:GET')]
    public function search(Request $request, Search $dormSearch): Response
    {
        $q = $request->query->get('query');// in miad query to url ro migire - yani search moon - http://localhost/index.php/hotel/search?query=Azadi 
        $dorms = $dormSearch->search($q);
        

        return $this->render('dorm/search.html.twig', [ 
            'query' => $q,
            'dorms' => $dorms,
        ]);
    }
}
