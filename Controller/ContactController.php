<?php

namespace Claroline\NetThemeBundle\Controller;

use Claroline\CoreBundle\Persistence\ObjectManager;
use Claroline\CoreBundle\Manager\MailManager;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class ContactController extends Controller
{
    private $om;
    private $request;
    private $mailManager;

    /**
     * @DI\InjectParams({
     *     "om"            = @DI\Inject("claroline.persistence.object_manager"),
     *     "requestStack"  = @DI\Inject("request_stack"),
     *     "mailManager"   = @DI\Inject("claroline.manager.mail_manager")
     * })
     */
    public function __construct(
        ObjectManager $om,
        RequestStack $requestStack,
        MailManager $mailManager
    )
    {
        $this->om = $om;
        $this->request = $requestStack->getCurrentRequest();
        $this->mailManager = $mailManager;
    }

    /**
     * @EXT\Route(
     *     "/contact/email",
     *     name="claroline_net_email_contact",
     *     options={"expose"=true}
     * )
     */
    public function contactEmailAction()
    {
        $post = $this->request->request->all();

        //are you a bot ?
        $itsAtrap = $post['trap_field_contact']; //#admiral ackbar

        if ($itsAtrap != '') {
            throw new \Exception('nope'); //ahah
        }
        
        $subject = 'Contact depuis claroline.net de ' . $post['name'] . ' ' . $post['email'] . ':' . $post['subject'] ;
        $body = $post['message'];
        $to = 'olivier.meinguet@gmail.com';
        $extra['to'] = array($to);

        $from = null;

        $this->mailManager->send(
            $subject, $body, array(), $from, $extra, true
        );

        return new JsonResponse("success");
    }

    /**
     * @EXT\Route(
     *     "/contact/newsletter",
     *     name="claroline_net_email_newsletter",
     *     options={"expose"=true}
     * )
     */
    public function newsLetterAction()
    {
        $post = $this->request->request->all();

        //are you a bot ?
        $itsAtrap = $post['trap_field_newsletter']; //#admiral ackbar

        if ($itsAtrap != '') {
            throw new \Exception('nope'); //ahah
        }

        $subject = "Demande d'inscription à la newsletter de Claroline" ;
        $body = "email: " . $post['newsletter'];
        $to = 'pascal.balancier@adn.aei.be';
        $extra['to'] = array($to);

        $from = null;

        $this->mailManager->send(
            $subject, $body, array(), $from, $extra, true
        );

        return new JsonResponse("success");
    }
}
