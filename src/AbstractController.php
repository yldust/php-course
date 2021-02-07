<?php
namespace Base;

use App\Model\User;

abstract class AbstractController
{
    /** @var View */
    protected $view;
    /** @var Session */
    protected $session;

    /**
     * @param string $url
     * @throws RedirectException
     */
    protected function redirect(string $url): void
    {
        throw new RedirectException($url);
    }

    /**
     * @param View $view
     */
    public function setView(View $view): void
    {
        $this->view = $view;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function getUserId()
    {
        $userId = $this->session->getUserId();

        if ($userId) {
            return $userId;
        }

        return false;
    }

    public function isUserAuthorized()
    {
        return $this->getUserId();
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        $userId = $this->getUserId();

        if (!$userId) {
            return null;
        }

        $user = User::getById($userId);

        if (!$user) {
            return null;
        }

        return $user;
    }
}