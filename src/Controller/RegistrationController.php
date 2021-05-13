<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\AppUserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(EntityManagerInterface $entityManager,Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppUserAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $passwordCrypte = $passwordEncoder->encodePassword($user, $user->getPassword()); //$form->get('plainPassword')->getData());
            $user->setPassword($passwordCrypte);
            // $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('aliments');


            // // generate a signed url and email it to the user
            // $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            //     (new TemplatedEmail())
            //         ->from(new Address('kenjyzakary@hotmail.fr', 'Symfony Mail Verification'))
            //         ->to($user->getEmail())
            //         ->subject('Please Confirm your Email')
            //         ->htmlTemplate('registration/confirmation_email.html.twig')
            // );
            // // do anything else you need here, like send an email

            // return $guardHandler->authenticateUserAndHandleSuccess(
            //     $user,
            //     $request,
            //     $authenticator,
            //     'main' // firewall name in security.yaml
            // );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/verify/email", name="app_verify_email")
    //  */
    // public function verifyUserEmail(Request $request): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    //     // validate email confirmation link, sets User::isVerified=true and persists
    //     try {
    //         $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    //     } catch (VerifyEmailExceptionInterface $exception) {
    //         $this->addFlash('verify_email_error', $exception->getReason());

    //         return $this->redirectToRoute('app_register');
    //     }

    //     // @TODO Change the redirect on success and handle or remove the flash message in your templates
    //     $this->addFlash('success', 'Your email address has been verified!!!!');

    //     return $this->redirectToRoute('aliments');
    // }

    //     /**
    //  * @Route("/verify", name="registration_confirmation_route")
    //  */
    // public function verifyUserEmail(Request $request): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    //     $user = $this->getUser();

    //     // Do not get the User's Id or Email Address from the Request object
    //     try {
    //         $this->helper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());
    //     } catch (VerifyEmailExceptionInterface $e) {
    //         $this->addFlash('verify_email_error', $e->getReason());

    //         return $this->redirectToRoute('app_register');
    //     }

    //     // Mark your user as verified. e.g. switch a User::verified property to true

    //     $this->addFlash('success', 'Your e-mail address has been verified.');

    //     return $this->redirectToRoute('app_home');
    // }
}
