<?php

/**
 * Part of starter project.
 *
 * @copyright  Copyright (C) 2021 __ORGANIZATION__.
 * @license    __LICENSE__
 */

declare(strict_types=1);

namespace App\Module\Admin\Sakura;

use App\Entity\Category;
use App\Entity\Sakura;
use App\Module\Admin\Category\CategoryRepository;
use App\Module\Admin\Category\Form\GridForm;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Attributes\ViewModel;
use Windwalker\Core\Form\FormFactory;
use Windwalker\Core\State\AppState;
use Windwalker\Core\View\ViewModelInterface;
use Windwalker\DI\Attributes\Autowire;
use Windwalker\ORM\ORM;
use Windwalker\Query\Query;

use function Windwalker\filter;

/**
 * The SakuraListView class.
 */
#[ViewModel(
    module: SakuraModule::class,
    layout: 'sakura-list',
    js: 'sakura-list.js'
)]
class SakuraListView implements ViewModelInterface
{
    /**
     * CategoriesView constructor.
     *
     * @param  ORM                 $orm
     * @param  SakuraRepository  $sakuraRepository
     * @param  FormFactory         $formFactory
     */
    public function __construct(
        protected ORM $orm,
        #[Autowire]
        protected SakuraRepository $sakuraRepository,
        protected FormFactory $formFactory
    ) {
    }

    public function prepare(AppState $state, AppContext $app): mixed
    {
        [$page, $limit] = $app->input('page', 'limit')->values();

        $page  = filter($page, 'int|range(min=1)');
        $limit = filter($limit, 'int') ?? 15;

        $filter   = (array) $state->rememberFromRequest('filter');
        $search   = (array) $state->rememberFromRequest('search');
        $ordering = $state->rememberFromRequest('list_ordering') ?? 'sakura.category_id ASC, sakura.ordering ASC';

        $items = $this->sakuraRepository->getListSelector()
            ->setFilters($filter)
            ->searchFor(
                $search['*'] ?? null,
                [
                    'sakura.title',
                    'sakura.content',
                ]
            )
            ->ordering($ordering)
            ->page($page)
            ->limit($limit);

        $pagination = $items->getPagination();

        $items = $items->getIterator(Sakura::class);

        // Form
        $form = $this->formFactory->create(GridForm::class);
        $form->fill(compact('search', 'filter'));

        $showFilters = $this->showFilterBar($filter);

        return compact('items', 'pagination', 'form', 'showFilters', 'ordering');
    }

    public function showFilterBar(array $filter): bool
    {
        foreach ($filter as $value) {
            if ($value !== null && (string) $value !== '') {
                return true;
            }
        }

        return false;
    }
}
