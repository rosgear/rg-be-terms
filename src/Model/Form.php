<?php
/**
 * Этот файл является частью модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Terms\Model;

use Ge\Panel\Data\Model\FormModel;

/**
 * Модель данных профиля термина.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Terms\Model
 * @since 1.0
 */
class Form extends FormModel
{
    /**
     * {@inheritdoc}
     */
    public function getDataManagerConfig(): array
    {
        return [
            'useAudit'   => false,
            'tableName'  => '{{term}}',
            'primaryKey' => 'id',
            // поля
            'fields' => [
                ['id'],
                [ // название
                    'name',
                    'label' => 'Name'
                ],
                [ // идентификатор компонента
                    'component_id', 
                    'alias' => 'componentId',
                    'label' => 'Component ID'
                ],
                [ // тип компонента 
                    'component_type',
                    'alias' => 'componentType',
                    'label' => 'Component type'
                ]
            ],
            // правила форматирования полей
            'formatterRules' => [
                [['name'], 'safe']
            ],
            // правила проверки полей
            'validationRules' => [
                [['name', 'componentId', 'componentType'], 'notEmpty']
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        $this
            ->on(self::EVENT_AFTER_SAVE, function ($isInsert, $columns, $result, $message) {
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
                /** @var \Ge\Panel\Controller\FormController $controller */
                $controller = $this->controller();
                // обновить список
                $controller->cmdReloadGrid();
            })
            ->on(self::EVENT_AFTER_DELETE, function ($result, $message) {
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg($message['message'], $message['title'], $message['type']);
                /** @var \Ge\Panel\Controller\FormController $controller */
                $controller = $this->controller();
                // обновить список
                $controller->cmdReloadGrid();
            });
    }
}
