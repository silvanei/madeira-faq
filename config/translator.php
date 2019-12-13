<?php

use Psr\Container\ContainerInterface;
use Zend\I18n\Translator\TranslatorInterface as I18nTranslatorInterface;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Translator\TranslatorInterface as ValidatorTranslatorInterface;

return function (ContainerInterface $container): void {

    $translator = $container->get('translator');

    AbstractValidator::setDefaultTranslator(
        new class ($translator) implements I18nTranslatorInterface, ValidatorTranslatorInterface {
            protected I18nTranslatorInterface $translator;

            public function __construct(I18nTranslatorInterface $translator)
            {
                $this->translator = $translator;
            }

            public function __call($method, array $args)
            {
                if (!method_exists($this->translator, $method)) {
                    throw new \BadMethodCallException(
                        sprintf(
                            'Unable to call method "%s"; does not exist in translator',
                            $method
                        )
                    );
                }
                return call_user_func_array([$this->translator, $method], $args);
            }

            public function getTranslator()
            {
                return $this->translator;
            }

            public function translate($message, $textDomain = 'default', $locale = null)
            {
                return $this->translator->translate($message, $textDomain, $locale);
            }

            public function translatePlural($singular, $plural, $number, $textDomain = 'default', $locale = null)
            {
                return $this->translator->translatePlural($singular, $plural, $number, $textDomain, $locale);
            }
        },
        'default'
    );
};
