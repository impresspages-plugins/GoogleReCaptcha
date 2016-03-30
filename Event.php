<?php
/**
 * @package   ImpressPages
 */


/**
 * Created by PhpStorm.
 * User: maskas
 * Date: 16.3.30
 * Time: 16.09
 */

namespace Plugin\GoogleReCaptcha;


class Event
{
    public static function ipInitFinished()
    {
        //replace default Captcha class by our version
        require_once('GoogleReCaptchaField.php');
        require_once('autoload.php');
    }

    public static function ipBeforeController()
    {
        ipAddJs('https://www.google.com/recaptcha/api.js');
    }


}
