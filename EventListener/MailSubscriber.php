<?php
namespace GollumSF\UserBundle\EventListener;

use GollumSF\EmailBundle\Sender\EmailSenderInterface;
use GollumSF\UserBundle\Event\AddUserConnectionEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * MailSubscriber
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class MailSubscriber implements EventSubscriberInterface {
	
	/**
	 * @var EmailSenderInterface
	 */
	private $emailSender;
	
	/**
	 * LoggerSubscriber constructor.
	 * @param LoggerInterface $logger
	 */
	public function __construct(EmailSenderInterface $emailSender) {
		$this->emailSender = $emailSender;
	}
	
	public function addUserConnectionEvent(AddUserConnectionEvent $event) {
		
		$userConnection = $event->getUserConnection();
		if ($userConnection->getProvider() == UserConnectionInterface::PROVIDER_EMAIL && !$userConnection->isConfirmed()) {
			$this->emailSender->sendFromAction('GollumSFUserBundle:Mail:confirmEmail', $userConnection->getProviderId(), [
				'userConnection' => $userConnection
			]);
		}
		
	}
	
	public static function getSubscribedEvents() {
		return [
			AddUserConnectionEvent::NAME => ['addUserConnectionEvent', 256],
		];
	}
	
}