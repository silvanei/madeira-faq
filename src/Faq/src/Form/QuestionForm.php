<?php

declare(strict_types=1);

namespace Faq\Form;

use Faq\Entity\Tag;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Select;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class QuestionForm extends Form
{
    /**
     * QuestionForm constructor.
     * @param string $name
     * @param array<array> $options
     */
    public function __construct(string $name = 'question', array $options = [])
    {
        parent::__construct($name, $options);

        $tags = array_map(fn(Tag $tag) => ['value' => $tag->id, 'label' => $tag->title], $options['tags']);

        $this->add(
            [
                'type' => Csrf::class,
                'name' => 'question_csrf',
                'options' => [
                    'csrf_options' => [
                        'timeout' => 600,
                    ],
                ],
            ]
        );

        $this->add(
            [
                'type' => Select::class,
                'name' => 'tags_id',
                'attributes' => [
                    'id' => 'tags_id'
                ],
                'options' => [
                    'label' => 'Categoria',
                    'label_attributes' => [
                        'class' => 'control-label'
                    ],
                    'empty_option' => 'Selecione uma Categoria',
                    'value_options' => $tags

                ]
            ]
        );

        $this->add(
            [
                'type' => Text::class,
                'name' => 'title',
                'options' => [
                    'label' => 'Pergunta',
                    'label_attributes' => [
                        'class' => 'control-label'
                    ],
                ],
            ]
        );

        $this->add(
            [
                'type' => Textarea::class,
                'name' => 'answer',
                'attributes' => [
                    'rows' => '10',
                ],
                'options' => [
                    'label' => 'Resposta',
                    'label_attributes' => [
                        'class' => 'control-label'
                    ],
                ],
            ]
        );

        $this->add(
            [
                'type' => Submit::class,
                'name' => 'submit',
                'options' => [
                    'label' => 'Salvar'
                ]
            ]
        );

        $this->setInputFilter($this->inputFilter());
    }

    private function inputFilter(): InputFilterInterface
    {
        $inputFilter = new InputFilter();

        $inputFilter->add(
            [
                'name' => 'tags_id',
                'required' => true,
                'filters' => [
                    ['name' => ToInt::class],
                ]
            ]
        );

        $inputFilter->add(
            [
                'name' => 'title',
                'required' => true,
                'filters' => [
                    ['name' => StripTags::class],
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 5,
                            'max' => 255,
                        ],
                    ],
                ],
            ]
        );

        $inputFilter->add(
            [
                'name' => 'answer',
                'required' => true,
                'validators' => [
                    [
                        'name' => StringLength::class,
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 5
                        ],
                    ],
                ],
            ]
        );

        return $inputFilter;
    }
}
