<?php
/**
 * Created by PhpStorm.
 * User: Eng samer i. alkahlout
 * Date: 12/1/2018
 * Time: 8:08 AM
 */


namespace App\Constants;

class Enum
{



    // role user

    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const CAPTAIN = 3;
    const PLACE = 4;
    const CUSTOMER = 5;

    //PAYMENT TYPE

    const IMMEDIATELY = 'immediately' ;
    const POSTPAID = 'postpaid' ;
    const LATER = 'later' ;

    //trip status
    const PENDING = 'pending';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';



}

