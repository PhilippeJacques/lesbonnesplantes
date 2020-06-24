<?php

namespace App\Notification;


use App\Entity\Contact;

use Twig\Environment;

class ContactNotification{


    /**
     * @var Environment
     */
    private $renderer;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {


        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact){
        /*$transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')->setUsername('pepephilippe287@gmail.com')->setPassword('jacques1286');

        $mailer = \Swift_Mailer::newInstance($transport);*/


        $message = (new \Swift_Message('Agence: '.$contact->getPlant()->getTitle()))
            ->setFrom('pepephilippe287@gmail.com')
            ->setTo('pepephilippe287@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig',
                ['contact'=>$contact]),'text/html');
        $this->mailer->send($message);
    }
}