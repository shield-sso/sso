<?php

declare(strict_types = 1);

namespace ShieldSSO\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Mailjet\MailjetSwiftMailer\SwiftMailer\MailjetTransport;
use RandomLib\Factory;
use ShieldSSO\Application;
use ShieldSSO\Contract\Repository\UserRepositoryInterface;
use ShieldSSO\Entity\User;
use Swift_Events_SimpleEventDispatcher;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class IndexController
{
    /**
     * @param Application $app
     *
     * @return Response
     */
    public function indexAction(Application $app): Response
    {
        return $app->render('index.html.twig');
    }

    /**
     * @param Application $app
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Application $app, Request $request): Response
    {
        if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
            return $app->redirect($app['url_generator']->generate('homepage'));
        }

        return $app->render('login.html.twig', [
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username')
        ]);
    }

    /**
     * @param Application $app
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Application $app, Request $request): Response
    {
        if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
            return $app->redirect($app['url_generator']->generate('homepage'));
        }

        $email = $request->get('email');
        $password = $request->get('password');
        $repeatedPassword = $request->get('repeat_password');

        if ($request->isMethod('POST')) {
            $valid = true;

            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $app['session']->getFlashBag()->add('register_error', 'Email address isn\'t correct');
                $valid = false;
            }

            if (empty($password)) {
                $app['session']->getFlashBag()->add('register_error', 'Password cannot be empty');
                $valid = false;
            }

            if ($password != $repeatedPassword) {
                $app['session']->getFlashBag()->add('register_error', 'Passwords don\'t match');
                $valid = false;
            }

            if ($valid) {
                $factory = new Factory;
                $generator = $factory->getMediumStrengthGenerator();
                $activationHash = sha1($bytes = $generator->generate(32));

                $user = new User();
                $user->setLogin($email);
                $user->setPassword(password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]));
                $user->setActive($activationHash);

                /** @var EntityManagerInterface $entityManager */
                $entityManager = $app['orm.em'];
                $entityManager->persist($user);
                $entityManager->flush();

                $activationLink = $app['url_generator']->generate(
                    'activate',
                    ['id' => $user->getId(), 'hash' => $activationHash],
                    UrlGeneratorInterface::ABSOLUTE_URL
                );

                if (getenv('APP_ENV') === 'dev') {
                    $transport = new Swift_SmtpTransport('localhost', 1025);
                    $transport = new Swift_Mailer($transport);
                } else {
                    $transport = new MailjetTransport(
                        new Swift_Events_SimpleEventDispatcher(),
                        getenv('MAILJET_API_KEY'),
                        getenv('MAILJET_SECRET_KEY')
                    );
                }

                $message = new Swift_Message(
                    'Shield SSO',
                    "<p>Activation link: <a href=\"{$activationLink}\">{$activationLink}</a></p>",
                    'text/html'
                );

                $message
                    ->addTo($email)
                    ->addFrom('shieldsso@danieliwaniec.com', 'Shield SSO')
                    ->addReplyTo('shieldsso@danieliwaniec.com', 'Shield SSO');

                $transport->send($message);

                $app['session']->getFlashBag()->add(
                    'register_success',
                    'User registered. Check email for activation link.'
                );

                return $app->redirect($app['url_generator']->generate('homepage'));
            }
        }

        return $app->render('register.html.twig', ['email' => $email]);
    }

    /**
     * @param Application $app
     * @param Request $request
     *
     * @return Response
     */
    public function activateAction(Application $app, Request $request): Response
    {
        $id = (int)$request->get('id');
        $hash = (string)$request->get('hash');

        /** @var UserRepositoryInterface $userRepository */
        $userRepository = $app['repository.user'];

        $user = $userRepository->getById($id);

        if ($user && $user->getActive() === $hash) {
            $user->setActive(null);

            /** @var EntityManagerInterface $entityManager */
            $entityManager = $app['orm.em'];
            $entityManager->persist($user);
            $entityManager->flush();

            $app['session']->getFlashBag()->add(
                'register_success',
                'User activated.'
            );
        } else {
            $app['session']->getFlashBag()->add(
                'register_error',
                'Activation error.'
            );
        }

        return $app->redirect($app['url_generator']->generate('homepage'));
    }
}
