<?php

namespace MaricTrading\Recaptcha\Form\Type;

use MaricTrading\Recaptcha\Service\RecaptchaService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class RecaptchaFormType extends AbstractType
{

    public function __construct(
        private RecaptchaService $recaptchaService,
    )
    {
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['recaptcha_site_key'] = $this->recaptchaService->getSiteKey();
        parent::buildView($view, $form, $options);
        //dd($view, $form,$options);
    }

    public function getParent()
    {
        return TextType::class;
    }


    public function getBlockPrefix()
    {
        return 'recaptcha';
    }

    public function getName()
    {
        return 'recaptcha';
    }
}
