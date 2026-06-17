<?php
/**
 * Этот файл является частью расширения модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Terms\Widget;

use Ge;
use Ge\Panel\Helper\ExtGrid;
use Ge\Panel\Helper\HtmlGrid;
use Ge\Panel\Helper\HtmlNavigator as HtmlNav;

/**
 * Виджет для формирования интерфейса вкладки с сеткой данных.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Terms\Widget
 * @since 1.0
 */
class TabGrid extends \Ge\Panel\Widget\TabGrid
{
    /**
     * {@inheritdoc}
     */
    protected function init(): void
    {
        parent::init();

        // столбцы (Ge.view.grid.Grid.columns GeJS)
        $this->grid->columns = [
            ExtGrid::columnNumberer(),
            ExtGrid::columnAction(),
            [
                'text'      => ExtGrid::columnInfoIcon($this->creator->t('Name')),
                'dataIndex' => 'name',
                'cellTip'   => HtmlGrid::tags([
                    HtmlGrid::header('{name}'),
                    HtmlGrid::fieldLabel($this->creator->t('Component type'), '{componentType}'),
                    HtmlGrid::fieldLabel($this->creator->t('Component ID'), '{componentId}')
                ]),
                'filter'   => ['type' => 'string'],
                'sortable' => true,
                'width'    => 170
            ],
            [
                'text'      => '#Component type',
                'dataIndex' => 'componentType',
                'cellTip'   => '{componentType}',
                'filter'    => ['type' => 'string'],
                'sortable'  => true,
                'width'     => 200
            ],
            [
                'text'      => '#Component ID',
                'dataIndex' => 'componentId',
                'filter'    => ['type' => 'string'],
                'sortable'  => true,
                'width'     => 250
            ]
        ];

        // панель инструментов (Ge.view.grid.Grid.tbar GeJS)
        $this->grid->tbar = [
            'padding' => 1,
            'items'   => ExtGrid::buttonGroups([
                'edit' => [
                    'items' => [
                        // инструмент "Добавить"
                        'add' => [
                            //'caching' => false
                        ],
                        'delete',
                        '-',
                        'edit',
                        'select',
                        '-',
                        'refresh'
                    ]
                ],
                'columns',
                'search'
            ])
        ];

        // контекстное меню записи (Ge.view.grid.Grid.popupMenu GeJS)
        $this->grid->popupMenu = [
            'cls'        => 'g-gridcolumn-popupmenu',
            'titleAlign' => 'center',
            'width'      => 150,
            'items'      => [
                [
                    'text'        => '#Edit record',
                    'iconCls'     => 'g-icon-svg g-icon-m_edit g-icon-m_color_default',
                    'handlerArgs' => [
                        'route'   => Ge::alias('@match', '/form/view/{id}'),
                        'pattern' => 'grid.popupMenu.activeRecord'
                    ],
                    'handler' => 'loadWidget'
                ]
            ]
        ];

        // 2-й клик по строке сетки
        $this->grid->rowDblClickConfig = [
            'allow' => true,
            'route' => Ge::alias('@match', '/form/view/{id}')
        ];
        // количество строк в сетке
        $this->grid->store->pageSize = 50;
        // поле аудита записи
        $this->grid->logField = 'name';
        // плагины сетки
        $this->grid->plugins = 'gridfilters';
        // класс CSS применяемый к элементу body сетки
        $this->grid->bodyCls = 'g-grid_background';

        // панель навигации (Ge.view.navigator.Info GeJS)
        $this->navigator->info['tpl'] = HtmlNav::tags([
            HtmlNav::header('{name}'),
            HtmlNav::fieldLabel($this->creator->t('Component type'), '{componentType}'),
            HtmlNav::fieldLabel($this->creator->t('Component ID'), '{componentId}'),
            HtmlNav::widgetButton(
                $this->creator->t('Edit record'),
                ['route' => Ge::alias('@match', '/form/view/{id}'), 'long' => true],
                ['title' => $this->creator->t('Edit record')]
            )
        ]);

        $this
            ->addCss(GE_DEBUG ? '/grid.css' : '/grid.min.css');
    }
}
