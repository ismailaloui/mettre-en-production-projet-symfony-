<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    protected $entityMananger;

    public function __construct(EntityManagerInterface $entityMananger)
    {
        $this->entityMananger = $entityMananger;
    }


    /**
     * @Route("/compte/adresses", name="account_address")
     */
    public function index(): Response
    {

        return $this->render('account/address.html.twig');
    }



    /**
     * @Route("/compte/ajouter-une-adresse", name="account_address_add")
     */
    public function add(Cart $cart, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->entityMananger->persist($address);
            $this->entityMananger->flush();

            if ($cart->get()) {

                return $this->redirectToRoute('order');
            } else {
                return $this->redirectToRoute('account_address');
            }
        }


        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_address_edit")
     */
    public function edit(Request $request, $id): Response
    {
        $address = $this->entityMananger->getRepository(Address::class)->findOneById($id);

        if (!$address || $address->getUser() != $this->getUser()) {

            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityMananger->flush();
            return $this->redirectToRoute('account_address');
        }
        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }




    /**
     * @Route("/compte/suprimmer-une-adresse/{id}", name="account_address_delete")
     */
    public function delete($id): Response
    {
        $address = $this->entityMananger->getRepository(Address::class)->findOneById($id);

        if ($address && $address->getUser() == $this->getUser()) {

            $this->entityMananger->remove($address);
            $this->entityMananger->flush();
        }





        return $this->redirectToRoute('account_address');
    }
}
