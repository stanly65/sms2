<?php

namespace AppBundle\Controller;


use Swift_Message;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ContactFormController extends Controller
{
    /**
     * Displays "Contact Us" page.
     *
     * This method builds a form with validation rules,
     * handles form if this was a POST type request and
     * renders "Contact Us" page if this was a GET type request.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createContactForm();
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->addFlash(
                    'success',
                    'Your form has been submitted. Thank you.'
                );
                $data = $form->getData();
                $this->sendEmail($data);
                unset($form);

                return $this->redirect($this->generateUrl('contact'));
            }
        }

        return $this->render('AppBundle:default:contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Sends an email with corresponding data.
     *
     * @param $data
     * @return RedirectResponse
     */
    private function sendEmail($data)
    {
        $message = Swift_Message::newInstance()
            ->setSubject('SMS SMS')
            ->setFrom('support@sms.vue2.eu')
            ->setTo('support@sms.vue2.eu')
            ->setBody(
                $this->renderView(
                    'AppBundle:default:email.html.twig', [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'message' => $data['message']
                    ]
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);
    }

    /**
     * Creates contact form.
     *
     * @return Form|FormInterface
     */
    private function createContactForm()
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'constraints' => new NotBlank,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'constraints' => new Email,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('message', TextareaType::class, [
                'constraints' => new Length(['min' => 3]),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'SEND MESSAGE',
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->getForm();
        return $form;
    }
}
