<?php


namespace Application\Application\Form\Inscription;

use Application\Application\Form\AbstractEntityFieldset;
use Application\Entity\Etablissement;
use Application\Entity\Inscription;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Persistence\ObjectManager;
use Laminas\Config\Config;
use Laminas\Config\Reader\Ini;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Collection;
use Laminas\Form\Element\Csrf;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Submit;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Session\Container;
use Laminas\Validator\Date;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

/**
 * Class InscriptionFieldset
 */
class InscriptionFieldset extends Fieldset implements InputFilterProviderInterface
{

    const INPUT_USERNAME = 'username';
    const INPUT_ESI = 'esi';
    const INPUT_PASSWORD = 'password1';
    const INPUT_PASSWORD2 = 'password2';
    const INPUT_SUBMIT = 'submit';
    const INPUT_FIRSTNAME = 'firstname';
    const INPUT_LASTNAME = 'lastname';
    const INPUT_EMAIL = 'email';
    const INPUT_BIRTHDATE = 'birthdate';
    const INPUT_CITY = 'city';
    const INPUT_POSTALCODE = 'postalcode';
    const INPUT_STREET = 'street';
    const INPUT_NUM_STREET = 'numstreet';
    const INPUT_ROLE = 'role';
    const INPUT_FIRST_MOBILITE = 'firstmobilite';
    const INPUT_HANDICAP = 'handicap';
    const INPUT_EMAIL_REFERENT = 'mailreferent';
    const INPUT_ETABLISSEMENT = 'etablissement';
    const CSRF = 'csrf';
    private Container $session;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('inscription');

        // Pour la validation CSRF
        $this->session = new Container();

        $this->setHydrator(new DoctrineHydrator($objectManager))
            ->setObject(new Inscription());

        $this->add([
            'type' => Hidden::class,
            'name' => 'id',
        ]);

        $this->add([
            'type' => Text::class,
            'name' => self::INPUT_FIRSTNAME,
            'options' => [
                'label' => 'Firstname'
            ],
            'attributes' => [
                'required' => true
            ]
        ]);

        $this->add([
            'type' => Text::class,
            'name' => self::INPUT_LASTNAME,
            'options' => [
                'label' => 'Lastname'
            ],
            'attributes' => [
                'required' => true
            ]
        ]);

        $this->add([
            'type' => \Laminas\Form\Element\Date::class,
            'name' => self::INPUT_BIRTHDATE,
            'options' => [
                'label' => 'Birthdate'
            ],
            'attributes' => [
            ]
        ]);

        $this->add([
            'type' => Text::class,
            'name' => self::INPUT_ESI,
            'options' => [
                'label' => 'ESI (if available)'
            ],
            'attributes' => [
                'id' => 'inputEsi',
                'placeholder' => 'urn:schac:personalUniqueCode:int:esi:<country_code>:<ENI>'
            ]
        ]);

        $this->add([
            'type' => Text::class,
            'name' => self::INPUT_CITY,
            'options' => [
                'label' => 'City',
            ],
            'attributes' => [
                'placeholder' => 'Caen'
            ]
        ]);

        $this->add([
            'type' => Text::class,
            'name' => self::INPUT_POSTALCODE,
            'options' => [
                'label' => 'Postcode',
            ],
            'attributes' => [
                'placeholder' => '14000'
            ]
        ]);

        $this->add([
            'type' => Text::class,
            'name' => self::INPUT_STREET,
            'options' => [
                'label' => 'Street',
            ],
            'attributes' => [
                'placeholder' => 'Esplanade de la paix'
            ]
        ]);

        $this->add([
            'type' => Text::class,
            'name' => self::INPUT_NUM_STREET,
            'options' => [
                'label' => 'N°',
            ],
            'attributes' => [
                'placeholder' => '4'
            ]
        ]);

        $this->add([
            'type' => Checkbox::class,
            'name' => self::INPUT_FIRST_MOBILITE,
            'options' => [
                'label' => 'This is my first mobility',
            ],
        ]);

        $this->add([
            'type' => Email::class,
            'name' => self::INPUT_EMAIL_REFERENT,
            'options' => [
                'label' => 'Email of your university referent',
            ],
        ]);

        $this->add([
            'type' => Select::class,
            'name' => self::INPUT_ETABLISSEMENT,
            'options' => [
                'label' => 'Etablissement',
            ],
        ]);
//        $this->add([
//            'type' => Collection::class,
//            'name' => 'categories',
//            'options' => [
//                'label' => 'Etablissement',
//                'count' => 2,
//                'should_create_template' => true,
//                'allow_add' => true,
//                'target_element' => [
//                    'type' => EtablissementFieldset::class,
//                ],
//            ],
//        ]);

        $this->add([
            'type' => Submit::class,
            'name' => self::INPUT_SUBMIT,
            'attributes' => [
                'value' => "Register",
                'class' => 'btn btn-success'
            ],
        ]);

        $this->add([
            'type' => Csrf::class,
            'name' => self::CSRF,
            'options' => [
                'csrf_options' => [
                    'session' => $this->session
                ],
            ]
        ]);
    }

    public function init()
    {
    }


    /**
     * @inheritDoc
     */
    public function getInputFilterSpecification()
    {
        $filterSpecification =[];

        $filterSpecification[self::INPUT_FIRSTNAME] = [
            'name' => self::INPUT_FIRSTNAME,
            'required' => true,
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 2
                    ]
                ]
            ]
        ];

        $filterSpecification[self::INPUT_LASTNAME] = [
            'name' => self::INPUT_LASTNAME,
            'required' => true,
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 2
                    ]
                ]
            ]
        ];

        $filterSpecification[self::INPUT_ESI] = [
            'name' => self::INPUT_ESI,
            'required' => false
        ];

        $filterSpecification[self::INPUT_BIRTHDATE] = [
            'name' => self::INPUT_BIRTHDATE,
            'required' => false,
            'validators' => [
                [
                    'name' => Date::class,
                ]
            ],
        ];

        $filterSpecification[self::INPUT_CITY] = [
            'name' => 'city',
            'required' => false,
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 1
                    ]
                ]
            ]
        ];

        $filterSpecification[self::INPUT_FIRST_MOBILITE] = [
            'name' => 'firstMobilite',
            'required' => false
        ];

        $filterSpecification[self::INPUT_EMAIL_REFERENT] = [
            'name' => self::INPUT_EMAIL_REFERENT,
            'required' => true
        ];

        $filterSpecification[self::INPUT_ETABLISSEMENT] = [
            'name' => 'etablissement',
            'required' => false
        ];

        if(getenv('APPLICATION_ENV') !== 'development') {

            $filterSpecification[self::CSRF] = [
                'name' => 'csrf',
                'validators' => [
                    [
                        'name' => \Laminas\Validator\Csrf::class,
                        'options' => [
                            'session' => $this->session
                        ]
                    ]
                ]
            ];
        }

        return $filterSpecification;
    }
}
