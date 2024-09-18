<?php

declare(strict_types=1);

namespace App\Menu\Infrastructure\DataFixtures\ORM;

use App\Menu\Domain\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Throwable;

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
        $pagesMenu->setTitle('Profile');
        $pagesMenu->setType('AppBar');
        $pagesMenu->setIcon('account_circle');
        $pagesMenu->setLink('/profile');
        $manager->persist($pagesMenu);

        // Ajout des sous-éléments sous "Pages"
        $pagesMenu1 = new Menu();
        $pagesMenu1->setAction('image');
        $pagesMenu1->setActive(false);
        $pagesMenu1->setTitle('Setting');
        $pagesMenu1->setType('AppBar');
        $pagesMenu1->setIcon('settings');
        $pagesMenu1->setLink('/setting');
        $manager->persist($pagesMenu1);

        $pagesMenu2 = new Menu();
        $pagesMenu2->setAction('image');
        $pagesMenu2->setActive(false);
        $pagesMenu2->setTitle('Logout');
        $pagesMenu2->setType('AppBar');
        $pagesMenu2->setIcon('logout');
        $pagesMenu2->setLink('/logout');
        $manager->persist($pagesMenu2);
    }
}
