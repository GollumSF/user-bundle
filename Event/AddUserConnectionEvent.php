<?php
namespace GollumSF\UserBundle\Event;

/**
 * AddUserConnectionEvent
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class AddUserConnectionEvent extends UserConnectionEvent {
	const NAME = 'gsf_user.add_user_connection';
}