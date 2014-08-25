<?php
class Site_Helper
{

    static function pagination($data, $page=1)
    {
        $adapter=new Zend_Paginator_Adapter_DbTableSelect($data);
        $paginator=new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setDefaultScrollingStyle('Elastic');
        $paginator->setItemCountPerPage(MAX_ROW);

        return $paginator;
    }

}