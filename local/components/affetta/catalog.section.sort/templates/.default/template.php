<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="sort">
    <span>Сортировать по:</span>

    <a href="<?=$arResult['FIELDS']['POPULAR']['URL']?>"
       class="<?=$arResult['FIELDS']['POPULAR']['CLASS']?>">Популярности</a>

    <a href="<?=$arResult['FIELDS']['ACTIVE_FROM']['URL']?>"
       class="<?=$arResult['FIELDS']['ACTIVE_FROM']['CLASS']?>">Наличию</a>

    <a href="<?=$arResult['FIELDS']['PRICE']['URL']?>"
       class="<?=$arResult['FIELDS']['PRICE']['CLASS']?>">Цене</a>
</div>

