<?php

declare(strict_types=1);

namespace App\User\Domain\Entity\Traits;

use App\Calendar\Domain\Entity\Event;
use App\Configuration\Domain\Entity\Configuration;
use App\Crm\Domain\Entity\TeamMember;
use App\Crm\Domain\Entity\UserPreference;
use App\Job\Domain\Entity\Applicant;
use App\Job\Domain\Entity\Company;
use App\Log\Domain\Entity\LogLogin;
use App\Log\Domain\Entity\LogLoginFailure;
use App\Log\Domain\Entity\LogRequest;
use App\Menu\Domain\Entity\Menu;
use App\Notification\Domain\Entity\Notification;
use App\Resume\Domain\Entity\Experience;
use App\Resume\Domain\Entity\Formation;
use App\Resume\Domain\Entity\Hobby;
use App\Resume\Domain\Entity\Language;
use App\Resume\Domain\Entity\Reference;
use App\Resume\Domain\Entity\Skill;
use App\Shop\Domain\Entity\Address;
use App\Shop\Domain\Entity\Cart;
use App\Shop\Domain\Entity\Order;
use App\User\Domain\Entity\Profile;
use App\User\Domain\Entity\User;
use App\User\Domain\Entity\UserGroup;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @package App\User
 */
trait UserRelations
{
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
    #[ORM\OneToOne(targetEntity: Profile::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'profile_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['User.profile'])]
    private ?Profile $profile = null;

    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: Configuration::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $configurations;

    #[ORM\OneToMany(
        mappedBy: 'user',
        targetEntity: Notification::class,
        cascade: ['persist', 'remove']
    )]
    private Collection $notifications;

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
     * User preferences
     *
     * List of preferences for this user, required ones have dedicated fields/methods
     *
     * This Collection can be null for one edge case ONLY:
     * if a currently logged-in user will be deleted and then refreshed from the session from one of the UserProvider
     * e.g. see LdapUserProvider::refreshUser() it might crash if $user->getPreferenceValue() is called
     *
     * @var Collection<UserPreference>|null
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserPreference::class, cascade: ['persist'])]
    private ?Collection $preferences = null;
    /**
     * List of all team memberships.
     *
     * @var Collection<TeamMember>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: TeamMember::class, cascade: ['persist'], fetch: 'LAZY', orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Assert\NotNull]
    #[Serializer\Expose]
    #[Serializer\Groups(['User_Entity'])]
    #[OA\Property(type: 'array', items: new OA\Items(ref: '#/components/schemas/TeamMembership'))]
    private Collection $memberships;

    /**
     * @var Collection<int, User>
     * Many Users can follow Many Users.
     */
    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'followers')]
    #[ORM\JoinTable(name: 'user_friends')]
    private Collection $following;

    /**
     * @var Collection<int, User>
     * Many Users can be followed by Many Users.
     */
    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'following')]
    private Collection $followers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Experience::class)]
    #[Groups([
        'User',

        self::SET_USER_PROFILE,
    ])]
    private Collection $experiences;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Hobby::class)]
    #[Groups([
        'User',

        self::SET_USER_PROFILE,
    ])]
    private Collection $hobbies;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Language::class)]
    #[Groups([
        'User',

        self::SET_USER_PROFILE,
    ])]
    private Collection $languages;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Reference::class)]
    #[Groups([
        'User',

        self::SET_USER_PROFILE,
    ])]
    private Collection $references;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Skill::class)]
    #[Groups([
        'User',

        self::SET_USER_PROFILE,
    ])]
    private Collection $skills;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Formation::class)]
    #[Groups([
        'User',

        self::SET_USER_PROFILE,
    ])]
    private Collection $formations;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Applicant::class, cascade: ['persist', 'remove'])]
    #[Groups([
        'User',
        'User.applicants',

        self::SET_USER_PROFILE,
        self::SET_USER_BASIC,
    ])]
    private Collection $applicants;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Company::class, cascade: ['persist', 'remove'])]
    #[Groups([
        'User',
        'User.company',
        self::SET_USER_PROFILE,
        self::SET_USER_BASIC,
    ])]
    private ?Company $company = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Address::class)]
    #[Groups([
        'User',
        'User.addresses',
        self::SET_USER_PROFILE,
        self::SET_USER_BASIC,
    ])]
    private Collection $addresses;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Order::class)]
    #[Groups([
        'User',
        'User.orders',
        self::SET_USER_PROFILE,
        self::SET_USER_BASIC,
    ])]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Cart::class)]
    #[Groups([
        'User',
        'User.carts',
        self::SET_USER_PROFILE,
        self::SET_USER_BASIC,
    ])]
    private Collection $carts;

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
        if ($this->events->removeElement($event)) {
            if ($event->getUser() === $this) {
                $event->setUser(null);
            }
        }

        return $this;
    }

    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    /**
     * Get the users this user is following.
     */
    public function getFollowing(): Collection
    {
        return $this->following;
    }

    /**
     * Add a user to the following list.
     */
    public function follow(User $user): self
    {
        if (!$this->following->contains($user)) {
            $this->following[] = $user;
        }

        return $this;
    }

    /**
     * Remove a user from the following list.
     */
    public function unfollow(User $user): self
    {
        $this->following->removeElement($user);

        return $this;
    }

    /**
     * Get the users following this user.
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->setUser($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getUser() === $this) {
                $experience->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Hobby>
     */
    public function getHobbies(): Collection
    {
        return $this->hobbies;
    }

    public function addHobby(Hobby $hobby): static
    {
        if (!$this->hobbies->contains($hobby)) {
            $this->hobbies->add($hobby);
            $hobby->setUser($this);
        }

        return $this;
    }

    public function removeHobby(Hobby $hobby): static
    {
        if ($this->hobbies->removeElement($hobby)) {
            // set the owning side to null (unless already changed)
            if ($hobby->getUser() === $this) {
                $hobby->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Language>
     */
    public function getLanguages(): Collection
    {
        return $this->languages;
    }

    public function addLanguage(Language $language): static
    {
        if (!$this->languages->contains($language)) {
            $this->languages->add($language);
            $language->setUser($this);
        }

        return $this;
    }

    public function removeLanguage(Language $language): static
    {
        if ($this->languages->removeElement($language)) {
            // set the owning side to null (unless already changed)
            if ($language->getUser() === $this) {
                $language->setUser(null);
            }
        }

        return $this;
    }

    public function getReferences(): ArrayCollection|Collection
    {
        return $this->references;
    }

    public function addLReference(Reference $reference): static
    {
        if (!$this->references->contains($reference)) {
            $this->references->add($reference);
            $reference->setUser($this);
        }

        return $this;
    }

    public function removeReference(Reference $reference): static
    {
        if ($this->references->removeElement($reference)) {
            // set the owning side to null (unless already changed)
            if ($reference->getUser() === $this) {
                $reference->setUser(null);
            }
        }

        return $this;
    }

    public function getSkills(): ArrayCollection|Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->setUser($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getUser() === $this) {
                $skill->setUser(null);
            }
        }

        return $this;
    }

    public function getFormations(): ArrayCollection|Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->setUser($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getUser() === $this) {
                $formation->setUser(null);
            }
        }

        return $this;
    }

    public function getApplicants(): Collection
    {
        return $this->applicants;
    }

    public function addApplicant(Applicant $applicant): self
    {
        if (!$this->applicants->contains($applicant)) {
            $this->applicants[] = $applicant;
            $applicant->setUser($this);
        }

        return $this;
    }

    public function removeApplicant(Applicant $applicant): self
    {
        if ($this->applicants->removeElement($applicant)) {
            if ($applicant->getUser() === $this) {
                $applicant->setUser(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        // set the owning side of the relation if necessary
        if ($company !== null && $company->getUser() !== $this) {
            $company->setUser($this);
        }

        $this->company = $company;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts[] = $cart;
            $cart->setUser($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->removeElement($cart)) {
            // set the owning side to null (unless already changed)
            if ($cart->getUser() === $this) {
                $cart->setUser(null);
            }
        }

        return $this;
    }

}
