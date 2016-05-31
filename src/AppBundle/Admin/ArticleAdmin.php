<?php
// src/AppBundle/Admin/ArticleAdmin.php
namespace AppBundle\Admin;

use DateTime, IntlDateFormatter;

use Symfony\Component\Validator\Constraints as Assert;

use Sonata\AdminBundle\Admin\Admin,
    Sonata\AdminBundle\Datagrid\ListMapper,
    Sonata\AdminBundle\Datagrid\DatagridMapper,
    Sonata\AdminBundle\Form\FormMapper;

class ArticleAdmin extends Admin
{
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'number', [
                'label' => "ID",
            ])
            ->addIdentifier('title', 'text', [
                'label' => "Название",
            ])
            ->add('createdAt', 'datetime', [
                'label'    => "Дата и время публикации",
                'dateType' => IntlDateFormatter::LONG,
            ])
            ->add('views', 'number', [
                'label' => "Количество просмотров",
            ])
            ->add('isActive', 'boolean', [
                'label'    => "Отображается",
                'editable' => TRUE,
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Статья')
                ->with('Статья - Локализованные данные')
                    ->add('translations', 'a2lix_translations_gedmo', [
                        'label'              => FALSE,
                        'translatable_class' => 'AppBundle\Entity\Article',
                        'required'           => TRUE,
                        'fields' => [
                            'title' => [
                                'locale_options' => [
                                    'ru' => ['label' => "Название"],
                                    'en' => ['label' => "Title"],
                                ],
                            ],
                            'slug' => [
                                'display' => FALSE,
                            ],
                        ],
                    ])
                ->end()
                ->with('Статья - Общие данные')
                    ->add('createdAt', 'sonata_type_datetime_picker', [
                        'label'  => "Дата и время публикации",
                        'format' => 'dd-MM-yyyy HH:mm',
                        'attr'   => [
                            'data-date-format' => 'DD-MM-YYYY HH:mm',
                        ],
                    ])
                    ->add('views', 'number', [
                        'label'       => "Количество просмотров",
                        'constraints' => [
                            new Assert\Range(['min' => 0]),
                        ],
                    ])
                    ->add('isActive', 'checkbox', [
                        'required' => FALSE,
                        'label'    => "Отображается",
                    ])
                ->end()
            ->end()
            ->tab('Список блоков')
                ->with('Статья - блоки')
                    ->add('articleBlocks', 'sonata_type_collection', [
                        'label'        => FALSE,
                        'by_reference' => FALSE,
                        'required'     => TRUE,
                        'btn_add'      => 'Добавить блок'
                    ], [
                        'edit'     => 'inline',
                        'inline'   => 'table',
                    ])
                ->end()
            ->end()
        ;
    }

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('ApplicationSonataUserBundle:Admin/Form:form_admin_fields.html.twig')
        );
    }
}