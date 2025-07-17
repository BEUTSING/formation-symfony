<?php

namespace App\Controller;

use App\DTO\ContactDTO;
use App\Form\ContactTypeForm;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request,MailerInterface $mailer,): Response
    {
        $date=new ContactDTO();
// Initializing the DTO with default values
        // This is optional, but it can help avoid null values in the form
        
        $form=$this->createForm(ContactTypeForm::class, $date);
        $form->handleRequest($request);
//pour l'envoi des mails
        if ($form->isSubmitted() && $form->isValid()) {
            $mail=(new TemplatedEmail())
                ->to('beutsingjeanne762@gmail.com')
                ->from($date->email)
                ->subject('Contact Form Submission')
                ->htmlTemplate('contact.html.twig')
                ->context(['date' => $date]);
            try
            {
               
                $mailer->send($mail);
            }
            catch ( TransportExceptionInterface $e) {
                $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer plus tard.'. $e->getMessage());
                return $this->redirectToRoute('contact');
            }
            
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            return $this->redirectToRoute('contact');
        }
            
        // Render the form in the contact template

        return $this->render('contact/contact.html.twig',[
            'form' => $form,
        ]);
    }
}
