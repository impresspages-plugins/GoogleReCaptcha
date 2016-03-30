<?php

/**
 * @package ImpressPages
 *
 */

namespace Ip\Form\Field;

use Ip\Form\Field;


class Captcha extends Field
{

    private $captchaInit;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct($options = array())
    {
        parent::__construct($options);
    }

    /**
     * Render field
     *
     * @param string $doctype
     * @param $environment
     * @return string
     */
    public function render($doctype, $environment)
    {
        $siteKey = ipGetOption('GoogleReCaptcha.siteKey');
        return '
        <input ' . $this->getAttributesStr($doctype) . ' class="' . implode(
            ' ',
            $this->getClasses()
        ) . '" name="' . htmlspecialchars($this->getName()) . '" ' . $this->getValidationAttributesStr(
            $doctype
        ) . ' type="hidden" value="' . htmlspecialchars($this->getValue()) . '" />
        <div class="form-group g-recaptcha" data-sitekey="' . $siteKey . '"></div>
        ';
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return self::TYPE_SYSTEM;
    }

    /**
     * Validate input value
     *
     * @param $values
     * @param $valueKey
     * @param $environment
     * @return string
     */
    public function validate($values, $valueKey, $environment)
    {
        if (ipGetOption('GoogleReCaptcha.mode') == 'Development') {
           // return false;
        }

        $secret = ipGetOption('GoogleReCaptcha.secretKey');
        $recaptcha = new \ReCaptcha\ReCaptcha($secret);
        $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        if ($resp->isSuccess()) {
            return false;
        } else {
            $errorText = __('Sorry, we think you are a robot.', 'Ip', false);
            return $errorText;
        }
    }
//
//    /**
//     * Get validation input name
//     *
//     * @return string
//     */
//    public function getValidationInputName()
//    {
//        return $this->name . '[g-recaptcha-response]';
//    }

}
