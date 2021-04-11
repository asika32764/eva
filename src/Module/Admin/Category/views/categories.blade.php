<?php

/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app       AppContext      Application context.
 * @var $view      ViewModel       The view modal object.
 * @var $uri       SystemUri       System Uri information.
 * @var $chronos   ChronosService  The chronos datetime service.
 * @var $nav       Navigator       Navigator object to build route.
 * @var $asset     AssetService    The Asset manage service.
 * @var $lang      LangService     The language translation service.
 */

declare(strict_types=1);

use App\Entity\Category;
use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Asset\AssetService;
use Windwalker\Core\Attributes\ViewModel;
use Windwalker\Core\DateTime\ChronosService;
use Windwalker\Core\Language\LangService;
use Windwalker\Core\Pagination\Pagination;
use Windwalker\Core\Router\Navigator;
use Windwalker\Core\Router\SystemUri;

/**
 * @var $items      Category[]
 * @var $pagination Pagination
 */

$asset->css('https://unpkg.com/vue2-animate@2.1.4/dist/vue2-animate.min.css');

?>

@extends('admin.global.body')

@section('toolbar')
    @include('toolbar')
@stop

@push('script')
    {{--<script>--}}
    {{--    const state = {};--}}
    {{--</script>--}}
    <script defer>

    </script>
    <script>
        // const bs5 = System.import('@unicorn/ui/ui-bootstrap5.js?sdf').then(c => console.log(c));
    </script>
@endpush

@section('content')

    <form id="grid-form" action="" x-data="gridState"
        x-ref="gridForm"
        data-ordering="{{ $ordering }}"
        x-init="gridState.init($el)"
        method="post">

        @component('@filter-bar', ['open' => $showFilters], get_defined_vars())

        @endcomponent

        <div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 1%">
                        <input type="checkbox" data-task="toggle-all"
                            class="form-check-input"
                            @click="grid.toggleAll($event.target.checked)"
                        />
                    </th>
                    <th>
                        State
                    </th>
                    <th>
                        Title
                    </th>
                    <th>
                        Order
                    </th>
                    <th>
                        Delete
                    </th>
                    <th>
                        @component('@sort', ['field' => 'category.id'], get_defined_vars())
                            ID
                        @endcomponent
                    </th>
                </tr>
                </thead>

                <tbody>
                @foreach ($items as $i => $item)
                    <tr>
                        <td>
                            <input id="cb{{ $i }}" type="checkbox" name="id[]"
                                class="form-check-input"
                                value="{{ $item->getId() }}" data-role="grid-checkbox" />
                        </td>
                        <td>
                            <button class="btn btn-light btn-sm">
                                <span class="fa fa-check text-success"></span>
                            </button>
                        </td>
                        <td>
                            {{ str_repeat('—', $item->getLevel() - 1) }}
                            <a href="{{ $nav->to('category_edit')->id($item->getId()) }}">
                                {{ $item->getTitle() }}
                            </a>
                        </td>
                        <td>
                            {{ $item->getLft() }}
                        </td>
                        <td></td>
                        <td>
                            {{ $item->getId() }}
                        </td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <td colspan="20">
                        {!! $pagination->render() !!}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>

    </form>

@stop
