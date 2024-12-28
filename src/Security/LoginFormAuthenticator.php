<?php

namespace App\Security;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response; // Gerekli import
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // Yeni import
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator; // Doğru sınıf
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge; // Yeni import
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge; // Yeni import
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials; // Yeni import
use Symfony\Component\Security\Http\Authenticator\Passport\Passport; // Yeni import
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private EntityManagerInterface $entityManager;
    private UrlGeneratorInterface $urlGenerator;
    private CsrfTokenManagerInterface $csrfTokenManager;
    private UserPasswordHasherInterface $passwordHasher; // Yeni tip
    private UserRepository $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordHasherInterface $passwordHasher, // Yeni tip
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordHasher = $passwordHasher; // Yeni atama
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request): bool // Dönüş tipi eklendi
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport // Yeni metot ve dönüş tipi
    {
        $username = $request->request->get('username', '');
        $request->getSession()->set(Security::LAST_USERNAME, $username);

        return new Passport(
            new UserBadge($username, function() use($username) {
                $user = $this->userRepository->loadUserByUsername($username);

                if (!$user) {
                    throw new CustomUserMessageAuthenticationException('Email could not be found.');
                }

                return $user;
            }),
            new PasswordCredentials($request->request->get('password', ''))
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response // Dönüş tipi eklendi
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('dashboard'));
    }

    protected function getLoginUrl(Request $request): string // Dönüş tipi ve parametre eklendi
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}