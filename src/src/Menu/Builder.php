<?php


namespace App\Menu;

use App\Entity\Dorm;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Security; 

// use symfony\Component\Security\Core\Security;
class Builder
{

    private FactoryInterface $factory;
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(FactoryInterface $factory, EntityManagerInterface $entityManager , Security $security)
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function mainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        if (!$this->security->isGranted("IS_AUTHENTICATED_FULLY")) {
            $menu->addChild('Login', ['route' => 'app_login']); 
            $menu->addChild('Register', ['route' => 'app_register']);
        }else{
            $menu->addChild('Log out', ['route' => 'app_logout']); 
        }

        $menu->addChild('Home', ['route' => 'app_home']); 

        // create another menu item
        $menu->addChild('Rooms', ['route' => 'app_room_index']);
        // create another menu item
        $menu->addChild('universities', ['route' => 'app_university_index']);

        $dormsMenu = $menu->addChild('Dorms', ['route' => 'app_dorm_index']);

        /** @var dorm[] $dorms */
        $dorms = $this->entityManager->getRepository(Dorm::class)->findAll();

        foreach ($dorms as $dorm) {
            $dormsMenu->addChild($dorm->getName(), [
                'route' => 'app_dorm_show',
                'routeParameters' => ['id' => $dorm->getId()]
            ]);
        }

        return $menu;
    }

}
