<?php
namespace GollumSF\UserBundle\Event;

/**
 * RegisterUserEvent
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class RegisterUserEvent extends UserEvent {
	const NAME = 'gsf_user.register_user';
}