<?php
namespace GollumSF\AuthRestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * ResetPasswordType
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class ResetPasswordType extends AbstractType{
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('email', EmailType::class)
		;
	}
	
}