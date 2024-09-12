<?php

declare(strict_types=1);

namespace App\Menu\Infrastructure\DataFixtures\ORM;

use App\Menu\Domain\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Throwable;

use function array_map;

/**
 * @package App\Menu
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class LoadMenuData extends Fixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @throws Throwable
     */
    public function load(ObjectManager $manager): void
    {
        // Create entities
        $this->createMenu($manager);
        // Flush database changes
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     */
    public function getOrder(): int
    {
        return 3;
    }

    /**
     * Method to create User entity with specified role.
     *
     * @throws Throwable
     */
    private function createMenu(ObjectManager $manager): void
    {
        $pagesMenu = new Menu();
        $pagesMenu->setAction('image');
        $pagesMenu->setActive(false);
        $pagesMenu->setTitle('Extra');
        $manager->persist($pagesMenu);

        // Ajout des sous-éléments sous "Pages"
        $profileMenu = new Menu();
        $profileMenu->setTitle('Quiz');
        $profileMenu->setPrefix('P');
        $profileMenu->setActive(false);
        $profileMenu->setParent($pagesMenu);
        $profileMenu->setLevel(1);
        $manager->persist($profileMenu);

        // Ajout des sous-éléments sous "Profile"
        $profileOverview = new Menu();
        $profileOverview->setTitle('Start Quiz');
        $profileOverview->setPrefix('P');
        $profileOverview->setLink('/pages/pages/profile/overview');
        $profileOverview->setParent($profileMenu);
        $profileOverview->setLevel(2);
        $manager->persist($profileOverview);

        $allProjects = new Menu();
        $allProjects->setTitle('Results');
        $allProjects->setPrefix('A');
        $allProjects->setLink('/pages/pages/profile/projects');
        $allProjects->setParent($profileMenu);
        $allProjects->setLevel(3);
        $manager->persist($allProjects);

        $messages = new Menu();
        $messages->setTitle('Documentation');
        $messages->setPrefix('M');
        $messages->setLink('/pages/pages/profile/messages');
        $messages->setParent($profileMenu);
        $messages->setLevel(4);
        $manager->persist($messages);

        // Ajout de l'élément "Users"
        $usersMenu = new Menu();
        $usersMenu->setTitle('Crm');
        $usersMenu->setPrefix('U');
        $usersMenu->setActive(false);
        $usersMenu->setParent($pagesMenu);
        $usersMenu->setLevel(5);
        $manager->persist($usersMenu);

        // Ajout des sous-éléments sous "Users"
        $reports = new Menu();
        $reports->setTitle('Reports');
        $reports->setPrefix('R');
        $reports->setLink('/pages/pages/users/reports');
        $reports->setParent($usersMenu);
        $reports->setLevel(6);
        $manager->persist($reports);

        $newUser = new Menu();
        $newUser->setTitle('New User');
        $newUser->setPrefix('N');
        $newUser->setLink('/pages/pages/users/new-user');
        $newUser->setParent($usersMenu);
        $newUser->setLevel(7);
        $manager->persist($newUser);

        // Ajout des autres éléments de niveau supérieur comme "Applications", "Ecommerce", "Authentication", etc.
        $applicationsMenu = new Menu();
        $applicationsMenu->setAction('apps');
        $applicationsMenu->setActive(false);
        $applicationsMenu->setTitle('Test 1');
        $manager->persist($applicationsMenu);

        $ecommerceMenu = new Menu();
        $ecommerceMenu->setAction('shopping_basket');
        $ecommerceMenu->setActive(false);
        $ecommerceMenu->setTitle('Test 2');
        $manager->persist($ecommerceMenu);

        $authenticationMenu = new Menu();
        $authenticationMenu->setAction('content_paste');
        $authenticationMenu->setActive(false);
        $authenticationMenu->setTitle('Test 3');
        $manager->persist($authenticationMenu);
    }
}
