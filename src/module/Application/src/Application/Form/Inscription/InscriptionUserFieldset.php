<?php

namespace Application\Application\Form\Inscription;

use Application\Application\Service\Inscription\InscriptionServiceAwareTrait;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\Persistence\ObjectManager;
use Laminas\Form\Element\Collection;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Select;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;
use Laminas\Validator\StringLength;
use Laminas\Validator\UndisclosedPassword;
use UnicaenUtilisateur\Entity\Db\Role;
use UnicaenUtilisateur\Entity\Db\User;
use UnicaenUtilisateur\Service\Role\RoleServiceAwareTrait;
use UnicaenUtilisateur\Service\User\UserServiceAwareTrait;

class InscriptionUserFieldset extends Fieldset implements InputFilterProviderInterface
{

    const INPUT_USERNAME = 'username';
    const INPUT_DISPLAY_NAME = 'display_name';
    const INPUT_EMAIL = 'email';
    const INPUT_PASSWORD = 'password';
    const INPUT_PASSWORD2 = 'password2';
    const INPUT_ROLE = 'role';

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('user');
        $this->setHydrator(new DoctrineObject($objectManager))
            ->setObject(new User());

        $this->build();

    }

    public function build() {

        $this->add([
            'type' => Hidden::class,
            'name' => 'id',
        ]);

        $this->add([
            'type'       => Text::class,
            'name'       => self::INPUT_USERNAME,
            'options'    => [
                'label' => "Username"
            ],
            'attributes' => [
                'placeholder' => ''
            ]
        ]);

        $this->add([
            'type'       => Email::class,
            'name'       => self::INPUT_EMAIL,
            'options'    => [
                'label' => 'Email'
            ],
            'attributes' => [
                'placeholder' => 'aurelien.cotentin@unicaen.fr'
            ]
        ]);

//        $this->add([
//            'type' => Collection::class,
//            'name' => self::INPUT_ROLE,
//            'options' => [
//                'count' => 3,
//                'target_element' => new Fieldset('yoh', ['uech' => 'ui'])
//            ],
//        ]);

        $this->add([
            'type' => Hidden::class,
            'name' => self::INPUT_ROLE,
            'attributes' => [
                'id' => 'role',
                'value' => 'etudiant'
            ]
        ]);

        $this->add([
            'type'       => Password::class,
            'name'       => self::INPUT_PASSWORD,
            'options'    => [
                'label' => 'Password'
            ],
            'attributes' => [
                'id' => 'inputPw'
            ]
        ]);

        $this->add([
            'type'    => Password::class,
            'name'    => self::INPUT_PASSWORD2,
            'options' => [
                'label' => 'Password verification',
            ],
            'attributes' => [
                'id' => 'inputPw2'
            ]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getInputFilterSpecification()
    {
        $filterSpecification = [];

        $filterSpecification[self::INPUT_USERNAME] = [
            'name' => 'username',
            'required' => true,
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 1
                    ]
                ]
            ]
        ];

        $filterSpecification[self::INPUT_EMAIL] = [
            'name' => 'email',
            'required' => true,
            'validators' => [
                [
                    'name' => EmailAddress::class
                ]
            ]
        ];

        $filterSpecification[self::INPUT_PASSWORD] = [
            'name' => 'password',
            'required' => true,
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'min' => 8
                    ]
                ],
                [
                    'name' => Identical::class,
                    'options' => [
                        'token' => 'password2',
                        'message' => 'Passwords doesn\'t match'
                    ]
                ]
            ]
        ];

        return $filterSpecification;
    }

}