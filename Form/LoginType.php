<?php
namespace GollumSF\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * LoginType
 *
 * @author Damien Duboeuf <smeagolworms4@gmail.com>
 */
class LoginType extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('email', EmailType::class, [
				'label' => 'gsf_user.form.login.email'
			])
			->add('plainPassword', PasswordType::class, [
				'label' => 'gsf_user.form.login.password'
			])
			->add('submit', SubmitType::class, [
				'label' => 'gsf_user.form.login.submit'
			])
		;
	}
	
}