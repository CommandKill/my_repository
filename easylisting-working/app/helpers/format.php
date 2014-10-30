<?php

Class Format{

    static function simpleDate($d)
    {
        $date = date_create($d);
        return date_format($date, 'l jS F Y');
    }

}