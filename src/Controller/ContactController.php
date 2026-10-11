<?php

namespace App\Controller;

use App\Form\ContactType;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    public function __construct(
        #[Autowire('%env(CONTACT_EMAIL)%')] private string $contactEmail,
        #[Autowire('%env(MAILER_FROM)%')] private string $mailerFrom,
    ) {}

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer, LoggerInterface $logger): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Honeypot rempli => robot : on fait semblant que tout va bien
            if (!empty($form->get('website')->getData())) {
                $this->addFlash('success', 'Merci, votre message a bien été envoyé !');
                return $this->redirectToRoute('app_contact');
            }

            $data = $form->getData();

            $email = (new TemplatedEmail())
                // Sur OVH, l'expéditeur doit être une adresse de votre domaine
                ->from(new Address($this->mailerFrom, 'Bravo Cuistot'))
                ->to($this->contactEmail)
                ->replyTo(new Address($data['email'], $data['nom']))
                ->subject('[Contact] ' . $data['sujet'])
                ->htmlTemplate('emails/contact.html.twig')
                ->textTemplate('emails/contact.txt.twig')
                ->context(['contact' => $data]);

            try {
                $mailer->send($email);
                $this->addFlash('success', 'Merci, votre message a bien été envoyé ! Nous vous répondrons rapidement.');
            } catch (TransportExceptionInterface $e) {
                $logger->error('Échec envoi formulaire contact : ' . $e->getMessage());
                $this->addFlash('danger', 'Une erreur est survenue lors de l\'envoi. Merci de réessayer plus tard.');
            }

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}

