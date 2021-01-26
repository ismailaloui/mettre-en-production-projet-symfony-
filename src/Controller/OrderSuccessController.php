<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }




    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }


        if ($order->getState() == 0) {

            //vider la ssesion carte
            $cart->remove();
            //Modifier le statut ispaid de notre commande en metant 1
            $order->setState(1);
            $this->entityManager->flush();
            //envoyer un email à notre client pour confirmer sa commande
            $mail = new Mail();
            $content = "Bonjour  " . $order->getUser()->getFirstname() . "<br/> Merci pour votre commande.<br/>  Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page, le texte définitif venant remplacer le faux-texte dès qu'il est prêt ou que la mise en page est achevée. Généralement, on utilise un texte en faux latin, le Lorem ipsum ou Lipsu  <br/>";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande chez la boutique francaise (Ismail Aloui) est bien validé', $content);
        }

        //afficher quelque information de la commande de l'utilisateur

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
