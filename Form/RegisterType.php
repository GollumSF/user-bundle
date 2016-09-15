<?php
namespace GollumSF\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * RegisterType
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class RegisterType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('email', EmailType::class)
			->add('plainPassword', RepeatedType::class, [
				'type' => PasswordType::class
			])
			->add('submit', SubmitType::class)
		;
	}
	
}