<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Interface\UserInterface as InterfaceUserInterface;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/room')]
class RoomController extends AbstractController
{
        /** @var  TokenStorageInterface */
    private $tokenStorage;

    /**
     * @param TokenStorageInterface  $storage
    */
    public function __construct(
        TokenStorageInterface $storage,
    )
    {
        $this->tokenStorage = $storage;
    }
    #[Route('/', name: 'app_room_index', methods: ['GET'])]
    public function index(RoomRepository $roomRepository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_room_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RoomRepository $roomRepository): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        $room->setCapacity(0);
        $room->setIsEmpty(true);
        $room->setUserAccounts([]);
        //  $token = $this->tokenStorage->getToken();
        //  if ($token instanceof TokenInterface) {
        //   /** @var User $user */
        //   $user = $token->getUser()->getUserIdentifier();
          
        //   $room->setCreatedUsername($user);
        //   $entity->setUpdatedUsername($user);
          
        //  }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $roomRepository->add($room, true);

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/new.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/getRoom', name: 'app_room_get', methods: ['GET','POST'])]
    public function getRoom(Room $room,Request $request, RoomRepository $roomRepository): Response
    {   
        $temp = [];
        $temp = $room->getUserAccounts();
        if ($room->getCapacity() == $room->getmaximumCapacity()) {
            $room->setIsEmpty(false);
        }else {
            $room->setIsEmpty(true);
            
            $result=true;
            $token = $this->tokenStorage->getToken();
            if ($token instanceof TokenInterface) {
            /** @var User $user */
                $user = $token->getUser()->getUserIdentifier();
                foreach ($temp as $u) {
                    if ($u == $user) {
                      $result = false;  
                    }
                }
                if ($result) {
                    $room->setCapacity($room->getCapacity()+1);
                    array_push($temp,$user)  ;
                    $room->setUserAccounts($temp);
                    $roomRepository->add($room, true);

                   
                }
               
            }
            
        }
        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        
       
    }
    #[Route('/{id}/leaveRoom', name: 'app_room_leave', methods: ['GET','POST'])]
    public function leaveRoom(Room $room,Request $request, RoomRepository $roomRepository): Response
    {   
        $temp = [];
        $temp1 = [];
        $temp = $room->getUserAccounts();
        $room->setIsEmpty(true);
        if($room->getCapacity() != 0) {
            
            $result=false;
            $token = $this->tokenStorage->getToken();
            if ($token instanceof TokenInterface) {
            /** @var User $user */
                $user = $token->getUser()->getUserIdentifier();
                foreach ($temp as $u) {
                    if ($u == $user) {
                      $result = true;  
                    }
                }
                if ($result) {
                    foreach ($temp as $u) {
                        if ($u != $user) {
                            array_push($temp1,$u)  ; 
                        }
                    }
                    $room->setCapacity($room->getCapacity()-1);
                    $room->setUserAccounts($temp1);
                    $roomRepository->add($room, true);

                   
                }
               
            }
            
        }
        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        
       
    }
    #[Route('/{id}', name: 'app_room_show', methods: ['GET'])]
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_room_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Room $room, RoomRepository $roomRepository): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roomRepository->add($room, true);

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('room/edit.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_room_delete', methods: ['POST'])]
    public function delete(Request $request, Room $room, RoomRepository $roomRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            $roomRepository->remove($room, true);
        }

        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
    }
}
