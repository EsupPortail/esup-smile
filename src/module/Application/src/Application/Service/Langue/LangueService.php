<?php

namespace Application\Service\Langue;

use Application\Application\Service\API\CommonEntityService;
use Application\Entity\Langue;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Laminas\I18n\Translator\TranslatorInterface;
use Laminas\Session\Container;
use Locale;

class LangueService extends CommonEntityService
{
    use TranslatorAwareTrait;
//    use HistoEntityServiceTrait;
    /**
     * @inheritDoc
     */
    protected $translator;

    public function getEntityClass()
    {
        return Langue::class;
    }

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->setTranslator($translator);
    }

    // write a function to change the language of the user
    // using Laminas\I18n\Translator\Translator and Laminas\Session\Container
    // the function should be called in the controller
    public function changeLangue($langue)
    {
        $translator = $this->getTranslator();
        $translator->addTranslationFilePattern('gettext', __DIR__.'/language', '%s.mo');
        $test = $translator->setLocale($langue);

        $session = new Container('user_session');
        $session->language = $langue;
        $e = 1;
//        $translator = new Translator();
//        $translator->addTranslationFilePattern('gettext', __DIR__.'/language', '%s.mo');
//        $translator->setLocale($langue);
//        $session = new Container('langue');
//        $session->langue = $langue;
    }

}