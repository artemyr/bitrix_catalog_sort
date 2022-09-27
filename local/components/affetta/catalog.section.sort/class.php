<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;

class CatalogSectionSortComponent extends CBitrixComponent
{
    private $sort_variants = [
      'price','count','popular'
    ];

    private $sort_variants_values = [
        'price' => "CATALOG_PRICE_",
        'count' => 'ACTIVE_FROM',
        'popular' => 'SHOW_COUNTER'
    ];

    private $sort_orders = [
        'asc','desc'
    ];

    public function executeComponent()
    {
        global $APPLICATION;
        $this->sort_variants_values['price'] .= CCatalogGroup::GetBaseGroup()['ID'];

        if(!empty($_GET['sort_by'])) $this->arParams['SORT_BY'] = $_SESSION['PRODUCT_SORTING']['SORT_BY'] = $_GET['sort_by'];
        if(!empty($_GET['order'])) $this->arParams['SORT_ORDER'] = $_SESSION['PRODUCT_SORTING']['SORT_ORDER'] = $_GET['order'];

        if(!in_array($this->arParams['SORT_BY'], $this->sort_variants)) $this->arParams['SORT_BY'] = 'popular';
        if(!in_array($this->arParams['SORT_ORDER'], $this->sort_orders)) $this->arParams['SORT_ORDER'] = 'desc';


        // global
        $GLOBALS['arrSort']['ORDER_BY'] = $this->sort_variants_values[$this->arParams['SORT_BY']];
        $GLOBALS['arrSort']['SORT_ORDER'] = $this->arParams['SORT_ORDER'];
        // quantity
        if($this->arParams['SORT_BY'] == 'count' && $this->arParams['SORT_ORDER'] == 'desc') {
            $GLOBALS['arrSort']['QUANTITY'] = 'L';
        } else {
            $GLOBALS['arrSort']['QUANTITY'] = 'N';
        }
        // /global


//        for template
        $this->arResult['FIELDS']['ACTIVE_FROM']['ACTIVE'] = $this->arResult['FIELDS']['POPULAR']['ACTIVE'] = $this->arResult['FIELDS']['PRICE']['ACTIVE'] = 'N';

        if($this->arParams['SORT_BY'] == 'count') $this->arResult['FIELDS']['ACTIVE_FROM']['ACTIVE'] = 'Y';
        if($this->arParams['SORT_BY'] == 'price') $this->arResult['FIELDS']['PRICE']['ACTIVE'] = 'Y';
        if($this->arParams['SORT_BY'] == 'popular') $this->arResult['FIELDS']['POPULAR']['ACTIVE'] = 'Y';

        $this->arResult['ORDER'] = $this->arParams['SORT_ORDER'];

        $page = $APPLICATION->GetCurPage();

        $this->arResult['FIELDS']['ACTIVE_FROM']['URL'] = $page.'?order='.($this->arParams['SORT_ORDER'] == 'desc'?'asc':'desc').'&sort_by=count';
        $this->arResult['FIELDS']['PRICE']['URL'] = $page.'?order='.($this->arParams['SORT_ORDER'] == 'desc'?'asc':'desc').'&sort_by=price';
        $this->arResult['FIELDS']['POPULAR']['URL'] = $page.'?order='.($this->arParams['SORT_ORDER'] == 'desc'?'asc':'desc').'&sort_by=popular';

        if($this->arResult['FIELDS']['ACTIVE_FROM']['ACTIVE'] == 'Y') {
            $this->arResult['FIELDS']['ACTIVE_FROM']['CLASS'] = $this->arParams['SORT_ORDER'];
        }
        if($this->arResult['FIELDS']['POPULAR']['ACTIVE'] == 'Y') {
            $this->arResult['FIELDS']['POPULAR']['CLASS'] = $this->arParams['SORT_ORDER'];
        }
        if($this->arResult['FIELDS']['PRICE']['ACTIVE'] == 'Y') {
            $this->arResult['FIELDS']['PRICE']['CLASS'] = $this->arParams['SORT_ORDER'];
        }

        $this->IncludeComponentTemplate();
    }
}

