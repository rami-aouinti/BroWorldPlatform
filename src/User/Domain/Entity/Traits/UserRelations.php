<?php

declare(strict_types=1);

namespace App\User\Domain\Entity\Traits;

use App\Calendar\Domain\Entity\Event;
use App\Configuration\Domain\Entity\Configuration;
use App\Log\Domain\Entity\LogLogin;
use App\Log\Domain\Entity\LogLoginFailure;
use App\Log\Domain\Entity\LogRequest;
use App\Menu\Domain\Entity\Menu;
use App\User\Domain\Entity\Profile;
use App\User\Domain\Entity\User;
use App\User\Domain\Entity\UserGroup;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @package App\User
 */
trait UserRelations
{

    #[ORM\OneToOne(targetEntity: Profile::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'profile_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['User.profile'])]
    private ?Profile $profile = null;

    /**
     * @var Collection<int, UserGroup>|ArrayCollection<int, UserGroup>
     */
    #[ORM\ManyToMany(
        targetEntity: UserGroup::class,
        inversedBy: 'users',
    )]
    #[ORM\JoinTable(name: 'user_has_user_group')]
    #[Groups([
        'User.userGroups',
    ])]
    protected Collection | ArrayCollection $userGroups;

    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: Configuration::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $configurations;

    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: Event::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $events;

    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: Menu::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $menus;

    /**
     * @var Collection<int, LogRequest>|ArrayCollection<int, LogRequest>
     */
    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: LogRequest::class,
    )]
    #[Groups([
        'User.logsRequest',
    ])]
    protected Collection | ArrayCollection $logsRequest;

    /**
     * @var Collection<int, LogLogin>|ArrayCollection<int, LogLogin>
     */
    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: LogLogin::class,
    )]
    #[Groups([
        'User.logsLogin',
    ])]
    protected Collection | ArrayCollection $logsLogin;

    /**
     * @var Collection<int, LogLoginFailure>|ArrayCollection<int, LogLoginFailure>
     */
    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: LogLoginFailure::class,
    )]
    #[Groups([
        'User.logsLoginFailure',
    ])]
    protected Collection | ArrayCollection $logsLoginFailure;


    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Getter for roles.
     *
     * Note that this will only return _direct_ roles that user has and
     * not the inherited ones!
     *
     * If you want to get user inherited roles you need to implement that
     * logic by yourself OR use eg. `/user/{uuid}/roles` API endpoint.
     *
     * @return array<int, string>
     */
    #[Groups([
        'User.roles',

        User::SET_USER_PROFILE,
    ])]
    public function getRoles(): array
    {
        return $this->userGroups
            ->map(static fn (UserGroup $userGroup): string => $userGroup->getRole()->getId())
            ->toArray();
    }

    /**
     * Getter for user groups collection.
     *
     * @return Collection<int, UserGroup>|ArrayCollection<int, UserGroup>
     */
    public function getUserGroups(): Collection | ArrayCollection
    {
        return $this->userGroups;
    }

    /**
     * Getter for user request log collection.
     *
     * @return Collection<int, LogRequest>|ArrayCollection<int, LogRequest>
     */
    public function getLogsRequest(): Collection | ArrayCollection
    {
        return $this->logsRequest;
    }

    /**
     * Getter for user login log collection.
     *
     * @return Collection<int, LogLogin>|ArrayCollection<int, LogLogin>
     */
    public function getLogsLogin(): Collection | ArrayCollection
    {
        return $this->logsLogin;
    }

    /**
     * Getter for user login failure log collection.
     *
     * @return Collection<int, LogLoginFailure>|ArrayCollection<int, LogLoginFailure>
     */
    public function getLogsLoginFailure(): Collection | ArrayCollection
    {
        return $this->logsLoginFailure;
    }

    /**
     * Method to attach new user group to user.
     */
    public function addUserGroup(UserGroup $userGroup): self
    {
        if ($this->userGroups->contains($userGroup) === false) {
            $this->userGroups->add($userGroup);
            $userGroup->addUser($this);
        }

        return $this;
    }

    /**
     * Method to remove specified user group from user.
     */
    public function removeUserGroup(UserGroup $userGroup): self
    {
        if ($this->userGroups->removeElement($userGroup)) {
            $userGroup->removeUser($this);
        }

        return $this;
    }

    /**
     * Method to remove all many-to-many user group relations from current user.
     */
    public function clearUserGroups(): self
    {
        $this->userGroups->clear();

        return $this;
    }

    public function getConfigurations(): Collection
    {
        return $this->configurations;
    }

    public function addConfiguration(Configuration $configuration): self
    {
        if (!$this->configurations->contains($configuration)) {
            $this->configurations[] = $configuration;
            $configuration->setUser($this);
        }

        return $this;
    }

    public function removeConfiguration(Configuration $configuration): self
    {
        if ($this->configurations->removeElement($configuration)) {
            if ($configuration->getUser() === $this) {
                $configuration->setUser(null);
            }
        }

        return $this;
    }

    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setUser($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            if ($menu->getUser() === $this) {
                $menu->setUser(null);
            }
        }

        return $this;
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setUser($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->menus->removeElement($event)) {
            if ($event->getUser() === $this) {
                $event->setUser(null);
            }
        }

        return $this;
    }

}
