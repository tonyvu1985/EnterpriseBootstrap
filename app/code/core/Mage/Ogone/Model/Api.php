<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Ogone
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */

/**
 * Ogone payment method model
 */
class Mage_Ogone_Model_Api extends Mage_Payment_Model_Method_Abstract
{
    /**
     * Ogone payment method code
     *
     * @var string
     */
    const PAYMENT_CODE = 'ogone';

    protected $_code  = self::PAYMENT_CODE;
    protected $_formBlockType = 'ogone/form';
    protected $_infoBlockType = 'ogone/info';
    protected $_config = null;

     /**
     * Availability options
     */
    protected $_isGateway               = false;
    protected $_canAuthorize            = true;
    protected $_canCapture              = false;
    protected $_canCapturePartial       = false;
    protected $_canRefund               = false;
    protected $_canVoid                 = false;
    protected $_canUseInternal          = false;
    protected $_canUseCheckout          = true;
    protected $_canUseForMultishipping  = false;

    /**
     * "OUT" hash string components, correspond to the "IN" signature in Ogone.
     * "Out" relative to Magento, "in" relative to Ogone.
     *
     * @see Ogone eCommerce Advanced Technical Integration Guide v.5.0
     * @var array
     */
    protected static $_outAllMap = array(
        'ACCEPTURL', 'ADDMATCH', 'ADDRMATCH',
        // airline tickets - not implemented
//        'AIAIRNAME', 'AIAIRTAX', /*'AIBOOKIND*XX*', 'AICARRIER*XX*',*/ 'AICHDET', /*'AICLASS*XX*',*/ 'AICONJTI',
//        /*'AIDESTCITY*XX*', 'AIDESTCITYL*XX*', 'AIEXTRAPASNAME*XX*',*/ 'AIEYCD', /*'AIFLDATE*XX*', 'AIFLNUM*XX*',*/
//        'AIIRST', /*'AIORCITY*XX*', 'AIORCITYL*XX*',*/ 'AIPASNAME', /*'AISTOPOV*XX*',*/ 'AITIDATE', 'AITINUM',
//        'AITYPCH', 'AIVATAMNT', 'AIVATAPPL',
        'ALIAS','ALIASOPERATION', 'ALIASUSAGE',
        'ALLOWCORRECTION', 'AMOUNT', /*'AMOUNT*XX*',*/ 'AMOUNTHTVA', 'AMOUNTTVA', 'BACKURL', 'BGCOLOR', 'BRAND',
        'BRANDVISUAL', 'BUTTONBGCOLOR', 'BUTTONTXTCOLOR', 'CANCELURL', 'CARDNO', 'CATALOGURL', 'CAVV_3D',
        'CAVVALGORITHM_3D', 'CERTID', 'CHECK_AAV', 'CIVILITY', 'CN', 'COM', 'COMPLUS', 'COSTCENTER', 'COSTCODE',
        'CREDITCODE', 'CUID', 'CURRENCY', 'CVC', 'DATA', 'DATATYPE', 'DATEIN', 'DATEOUT', 'DECLINEURL', 'DEVICE',
        'DISCOUNTRATE', 'ECI',
        'ECOM_BILLTO_POSTAL_CITY', 'ECOM_BILLTO_POSTAL_COUNTRYCODE', 'ECOM_BILLTO_POSTAL_NAME_FIRST',
        'ECOM_BILLTO_POSTAL_NAME_LAST', 'ECOM_BILLTO_POSTAL_POSTALCODE', 'ECOM_BILLTO_POSTAL_STREET_LINE1',
        'ECOM_BILLTO_POSTAL_STREET_LINE2', 'ECOM_BILLTO_POSTAL_STREET_NUMBER', 'ECOM_CONSUMERID',
        'ECOM_CONSUMERORDERID', 'ECOM_CONSUMERUSERALIAS', 'ECOM_PAYMENT_CARD_EXPDATE_MONTH',
        'ECOM_PAYMENT_CARD_EXPDATE_YEAR', 'ECOM_PAYMENT_CARD_NAME', 'ECOM_PAYMENT_CARD_VERIFICATION',
        'ECOM_SHIPTO_COMPANY', 'ECOM_SHIPTO_DOB', 'ECOM_SHIPTO_ONLINE_EMAIL', 'ECOM_SHIPTO_POSTAL_CITY',
        'ECOM_SHIPTO_POSTAL_COUNTRYCODE', 'ECOM_SHIPTO_POSTAL_NAME_FIRST', 'ECOM_SHIPTO_POSTAL_NAME_LAST',
        'ECOM_SHIPTO_POSTAL_NAME_PREFIX', 'ECOM_SHIPTO_POSTAL_POSTALCODE', 'ECOM_SHIPTO_POSTAL_STREET_LINE1',
        'ECOM_SHIPTO_POSTAL_STREET_LINE2', 'ECOM_SHIPTO_POSTAL_STREET_NUMBER', 'ECOM_SHIPTO_TELECOM_FAX_NUMBER',
        'ECOM_SHIPTO_TELECOM_PHONE_NUMBER', 'ECOM_SHIPTO_TVA',
        'ED', 'EMAIL', 'EXCEPTIONURL', 'EXCLPMLIST', /*'EXECUTIONDATE*XX*',*/ 'FIRSTCALL', 'FLAG3D', 'FONTTYPE',
        'FORCECODE1', 'FORCECODE2', 'FORCECODEHASH', 'FORCEPROCESS', 'FORCETP', 'GENERIC_BL', 'GIROPAY_BL',
        'GIROPAY_ACCOUNT_NUMBER', 'GIROPAY_BLZ', 'GIROPAY_OWNER_NAME', 'GLOBORDERID', 'GUID', 'HDFONTTYPE',
        'HDTBLBGCOLOR', 'HDTBLTXTCOLOR', 'HEIGHTFRAME', 'HOMEURL', 'HTTP_ACCEPT', 'HTTP_USER_AGENT', 'INCLUDE_BIN',
        'INCLUDE_COUNTRIES', 'INVDATE', 'INVDISCOUNT', 'INVLEVEL', 'INVORDERID', 'ISSUERID',
        // cart items - not implemented
//        'ITEMCATEGORY*XX*', 'ITEMDISCOUNT*XX*', 'ITEMID*XX*', 'ITEMNAME*XX*', 'ITEMPRICE*XX*', 'ITEMQUANT*XX*',
//        'ITEMUNITOFMEASURE*XX*', 'ITEMVAT*XX*', 'ITEMVATCODE*XX*',
        'LANGUAGE', 'LEVEL1AUTHCPC', /*'LIDEXCL*XX*',*/ 'LIMITCLIENTSCRIPTUSAGE', 'LINE_REF',
        'LIST_BIN', 'LIST_COUNTRIES', 'LOGO', 'MERCHANTID', 'MODE', 'MTIME', 'MVER', 'NETAMOUNT', 'OPERATION',
        'ORDERID', 'ORDERSHIPCOST', 'ORDERSHIPTAX', 'ORDERSHIPTAXCODE',
        'ORIG', 'OR_INVORDERID', 'OR_ORDERID', 'OWNERADDRESS', 'OWNERADDRESS2', 'OWNERCTY', 'OWNERTELNO',
        'OWNERTOWN', 'OWNERZIP', 'PAIDAMOUNT', 'PARAMPLUS', 'PARAMVAR', 'PAYID', 'PAYMETHOD', 'PM', 'PMLIST',
        'PMLISTPMLISTTYPE', 'PMLISTTYPE', 'PMLISTTYPEPMLIST', 'PMTYPE', 'POPUP', 'POST', 'PSPID', 'PSWD', 'REF',
        'REFER', 'REFID', 'REFKIND', 'REF_CUSTOMERID', 'REF_CUSTOMERREF', 'REMOTE_ADDR', 'REQGENFIELDS','RTIMEOUT',
        'RTIMEOUTREQUESTEDTIMEOUT', 'SCORINGCLIENT', 'SETT_BATCH', 'SID', 'STATUS_3D', 'SUBSCRIPTION_ID', 'SUB_AM',
        'SUB_AMOUNT', 'SUB_COM', 'SUB_COMMENT', 'SUB_CUR', 'SUB_ENDDATE', 'SUB_ORDERID', 'SUB_PERIOD_MOMENT',
        'SUB_PERIOD_MOMENT_M', 'SUB_PERIOD_MOMENT_WW', 'SUB_PERIOD_NUMBER', 'SUB_PERIOD_NUMBER_D',
        'SUB_PERIOD_NUMBER_M', 'SUB_PERIOD_NUMBER_WW', 'SUB_PERIOD_UNIT', 'SUB_STARTDATE', 'SUB_STATUS', 'TAAL',
        /*'TAXINCLUDED*XX*',*/ 'TBLBGCOLOR', 'TBLTXTCOLOR', 'TID', 'TITLE', 'TOTALAMOUNT', 'TP', 'TRACK2', 'TXTBADDR2',
        'TXTCOLOR', 'TXTOKEN', 'TXTOKENTXTOKENPAYPAL', 'TYPE_COUNTRY', 'UCAF_AUTHENTICATION_DATA',
        'UCAF_PAYMENT_CARD_CVC2', 'UCAF_PAYMENT_CARD_EXPDATE_MONTH', 'UCAF_PAYMENT_CARD_EXPDATE_YEAR',
        'UCAF_PAYMENT_CARD_NUMBER', 'USERID', 'USERTYPE', 'VERSION', 'WBTU_MSISDN', 'WBTU_ORDERID', 'WEIGHTUNIT',
        'WIN3DS', 'WITHROOT',
    );
    protected static $_outShortMap = array('ORDERID', 'AMOUNT', 'CURRENCY', 'PSPID', 'OPERATION',);

    /**
     * "IN" hash string components, correspond to the "OUT" signature in Ogone.
     * "In" relative to Magento, "out" relative to Ogone.
     *
     * @see Ogone eCommerce Advanced Technical Integration Guide v.5.0
     * @var array
     */
    protected static $_inAllMap = array(
        'AAVADDRESS', 'AAVCHECK', 'AAVZIP', 'ACCEPTANCE', 'ALIAS', 'AMOUNT', 'BRAND', 'CARDNO', 'CCCTY', 'CN',
        'COMPLUS', 'CREATION_STATUS', 'CURRENCY', 'CVCCHECK', 'DCC_COMMPERCENTAGE', 'DCC_CONVAMOUNT', 'DCC_CONVCCY',
        'DCC_EXCHRATE', 'DCC_EXCHRATESOURCE', 'DCC_EXCHRATETS', 'DCC_INDICATOR', 'DCC_MARGINPERCENTAGE',
        'DCC_VALIDHOURS', 'DIGESTCARDNO', 'ECI', 'ED', 'ENCCARDNO', 'IP', 'IPCTY', 'NBREMAILUSAGE', 'NBRIPUSAGE',
        'NBRIPUSAGE_ALLTX', 'NBRUSAGE', 'NCERROR', 'ORDERID', 'PAYID', 'PM', 'SCO_CATEGORY', 'SCORING','STATUS',
        'SUBSCRIPTION_ID', 'TRXDATE', 'VC',
    );
    protected static $_inShortMap = array(
        'ORDERID', 'CURRENCY', 'AMOUNT', 'PM', 'ACCEPTANCE', 'STATUS', 'CARDNO', 'PAYID', 'NCERROR', 'BRAND',
        'DCC_INDICATOR', 'DCC_EXCHRATE', 'DCC_EXCHRATETS', 'DCC_CONVCCY', 'DCC_CONVAMOUNT', 'DCC_VALIDHOURS',
        'DCC_EXCHRATESOURCE', 'DCC_MARGINPERCENTAGE', 'DCC_COMMPERCENTAGE',
    );

    /* Ogone template modes */
    const TEMPLATE_OGONE            = 'ogone';
    const TEMPLATE_MAGENTO          = 'magento';

    /* Ogone payment process statuses */
    const PENDING_OGONE_STATUS      = 'pending_ogone';
    const CANCEL_OGONE_STATUS       = 'cancel_ogone';
    const DECLINE_OGONE_STATUS      = 'decline_ogone';
    const PROCESSING_OGONE_STATUS   = 'processing_ogone';
    const WAITING_AUTHORIZATION     = 'waiting_authorozation';
    const PROCESSED_OGONE_STATUS    = 'processed_ogone';

    /* Ogone responce statuses */
    const OGONE_PAYMENT_REQUESTED_STATUS    = 9;
    const OGONE_PAYMENT_PROCESSING_STATUS   = 91;
    const OGONE_AUTH_UKNKOWN_STATUS         = 52;
    const OGONE_PAYMENT_UNCERTAIN_STATUS    = 92;
    const OGONE_PAYMENT_INCOMPLETE          = 1;
    const OGONE_AUTH_REFUZED                = 2;
    const OGONE_AUTH_PROCESSING             = 51;
    const OGONE_TECH_PROBLEM                = 93;
    const OGONE_AUTHORIZED                  = 5;

    /* Layout of the payment method */
    const PMLIST_HORISONTAL_LEFT            = 0;
    const PMLIST_HORISONTAL                 = 1;
    const PMLIST_VERTICAL                   = 2;

    /* ogone paymen action constant*/
    const OGONE_AUTHORIZE_ACTION = 'RES';
    const OGONE_AUTHORIZE_CAPTURE_ACTION = 'SAL';

    /**
     * Parameters hashing context
     * @var string
     */
    const HASH_DIR_OUT = 'out';
    const HASH_DIR_IN = 'in';

    /**
     * Supported hashing algorithms
     * @var string
     */
    const HASH_SHA1 = 'sha1';
    const HASH_SHA256 = 'sha256';
    const HASH_SHA512 = 'sha512';

    /**
     * Init Ogone Api instance, detup default values
     *
     * @return Mage_Ogone_Model_Api
     */
    public function __construct()
    {
        $this->_config = Mage::getSingleton('ogone/config');
        return $this;
    }

    /**
     * Return ogone config instance
     *
     * @return Mage_Ogone_Model_Config
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * @deprecated after 1.4.1.0
     *
     * @param int storeId
     * @return bool
     */
    public function getDebug($storeId=null)
    {
        return $this->getDebugFlag();
    }

    /**
     * Flag witch prevent automatic invoice creation
     *
     * @return bool
     */
    public function isInitializeNeeded()
    {
        return true;
    }

    /**
     * Redirect url to ogone submit form
     *
     * @return string
     */
    public function getOrderPlaceRedirectUrl()
    {
          return Mage::getUrl('ogone/api/placeform', array('_secure' => true));
    }

    /**
     * Return payment_action value from config area
     *
     * @return string
     */
    public function getPaymentAction()
    {
        return $this->getConfig()->getConfigData('payment_action');
    }

    /**
     * Rrepare params array to send it to gateway page via POST
     *
     * @param Mage_Sales_Model_Order
     * @return array
     */
    public function getFormFields($order)
    {
        if (empty($order)) {
            if (!($order = $this->getOrder())) {
                return array();
            }
        }
        $billingAddress = $order->getBillingAddress();
        $formFields = array();
        $formFields['PSPID']    = $this->getConfig()->getPSPID();
        $formFields['orderID']  = $order->getIncrementId();
        $formFields['amount']   = round($order->getBaseGrandTotal()*100);
        $formFields['currency'] = Mage::app()->getStore()->getBaseCurrencyCode();
        $formFields['language'] = Mage::app()->getLocale()->getLocaleCode();

        $formFields['CN']       = $this->_translate($billingAddress->getFirstname().' '.$billingAddress->getLastname());
        $formFields['EMAIL']    = $order->getCustomerEmail();
        $formFields['ownerZIP'] = $billingAddress->getPostcode();
        $formFields['ownercty'] = $billingAddress->getCountry();
        $formFields['ownertown']= $this->_translate($billingAddress->getCity());
        $formFields['COM']      = $this->_translate($this->_getOrderDescription($order));
        $formFields['ownertelno']   = $billingAddress->getTelephone();
        $formFields['owneraddress'] =  $this->_translate(str_replace("\n", ' ',$billingAddress->getStreet(-1)));

        $paymentAction = $this->_getOgonePaymentOperation();
        if ($paymentAction ) {
            $formFields['operation'] = $paymentAction;
        }

        $formFields['homeurl']          = $this->getConfig()->getHomeUrl();
        $formFields['catalogurl']       = $this->getConfig()->getHomeUrl();
        $formFields['accepturl']        = $this->getConfig()->getAcceptUrl();
        $formFields['declineurl']       = $this->getConfig()->getDeclineUrl();
        $formFields['exceptionurl']    = $this->getConfig()->getExceptionUrl();
        $formFields['cancelurl']        = $this->getConfig()->getCancelUrl();

        if ($this->getConfig()->getConfigData('template')=='ogone') {
            $formFields['TP']= '';
            $formFields['PMListType'] = $this->getConfig()->getConfigData('pmlist');
        } else {
            $formFields['TP']= $this->getConfig()->getPayPageTemplate();
        }
        $formFields['TITLE']            = $this->_translate($this->getConfig()->getConfigData('html_title'));
        $formFields['BGCOLOR']          = $this->getConfig()->getConfigData('bgcolor');
        $formFields['TXTCOLOR']         = $this->getConfig()->getConfigData('txtcolor');
        $formFields['TBLBGCOLOR']       = $this->getConfig()->getConfigData('tblbgcolor');
        $formFields['TBLTXTCOLOR']      = $this->getConfig()->getConfigData('tbltxtcolor');
        $formFields['BUTTONBGCOLOR']    = $this->getConfig()->getConfigData('buttonbgcolor');
        $formFields['BUTTONTXTCOLOR']   = $this->getConfig()->getConfigData('buttontxtcolor');
        $formFields['FONTTYPE']         = $this->getConfig()->getConfigData('fonttype');
        $formFields['LOGO']             = $this->getConfig()->getConfigData('logo');

        $formFields['SHASign'] = $this->getHash($formFields, $this->getConfig()->getShaOutCode(), self::HASH_DIR_OUT,
            (int)$this->getConfig()->getConfigData('shamode'), $this->getConfig()->getConfigData('hashing_algorithm')
        );

        return $formFields;
    }

    /**
     * Debug specified order fields if needed
     *
     * @param Mage_Sales_Model_Order $order
     */
    public function debugOrder(Mage_Sales_Model_Order $order)
    {
        if ($this->getDebugFlag()) {
            $this->debugData(array('request' => $this->getFormFields($order)));
        }
    }

    /**
     * Create hash from provided data
     *
     * @param array $data
     * @param string $passPhrase
     * @param string $direction
     * @param bool|int $mapAllParams
     * @param string $algorithm
     * @return string
     * @throws Exception
     */
    public function getHash($data, $passPhrase, $direction, $mapAllParams = false, $algorithm = null)
    {
        // pick the right keys map depending on context
        if (self::HASH_DIR_OUT === $direction) {
            $hashMap = $mapAllParams ? '_outAllMap' : '_outShortMap';
        } elseif (self::HASH_DIR_IN === $direction) {
            $hashMap = $mapAllParams ? '_inAllMap' : '_inShortMap';
        } else {
            throw new Exception(sprintf('Unknown hashing context "%s".', $direction));
        }

        // collect non-empty data that maps and sort it alphabetically by key (uppercase)
        $collected = array();
        foreach ($data as $key => $value) {
            if (null !== $value && '' != $value) {
                $key = strtoupper($key);
                if (in_array($key, self::$$hashMap)) {
                    $collected[$key] = $value;
                }
            }
        }
        ksort($collected);

        if ($mapAllParams) {
            $nonHashed = $this->_concatenateAdvanced($collected, $passPhrase);
            if (empty($algorithm) || !in_array($algorithm, $this->getHashingAlgorithms(false))) {
                $algorithm = self::HASH_SHA256;
            }
        } else {
            $nonHashed = $this->_concatenateBasic($collected, $passPhrase, $hashMap);
            $algorithm = self::HASH_SHA1;
        }
        return strtoupper(hash($algorithm, $nonHashed));
    }

    /**
     * Get supported hashing algorithms as array
     *
     * @param bool $withLabels
     * @return array
     */
    public function getHashingAlgorithms($withLabels = true)
    {
        if ($withLabels) {
            return array(self::HASH_SHA1 => 'SHA-1', self::HASH_SHA256 => 'SHA-256', self::HASH_SHA512 => 'SHA-512');
        }
        return array(self::HASH_SHA1, self::HASH_SHA256, self::HASH_SHA512);
    }

    /**
     * to translate UTF 8 to ISO 8859-1
     * Ogone system is only compatible with iso-8859-1 and does not (yet) fully support the utf-8
     */
    protected function _translate($text)
    {
        return htmlentities(iconv("UTF-8", "ISO-8859-1", $text));
    }

    /**
     * Get Ogone Payment Action value
     *
     * @param string
     * @return string
     */
    protected function _getOgonePaymentOperation()
    {
        $value = $this->getPaymentAction();
        if ($value==Mage_Payment_Model_Method_Abstract::ACTION_AUTHORIZE) {
            $value = Mage_Ogone_Model_Api::OGONE_AUTHORIZE_ACTION;
        } elseif ($value==Mage_Payment_Model_Method_Abstract::ACTION_AUTHORIZE_CAPTURE) {
            $value = Mage_Ogone_Model_Api::OGONE_AUTHORIZE_CAPTURE_ACTION;
        }
        return $value;
    }

    /**
     * get formated order description
     *
     * @param Mage_Sales_Model_Order
     * @return string
     */
    protected function _getOrderDescription($order)
    {
        $invoiceDesc = '';
        $lengs = 0;
        foreach ($order->getAllItems() as $item) {
            if ($item->getParentItem()) {
                continue;
            }
            //COM filed can only handle max 100
            if (Mage::helper('core/string')->strlen($invoiceDesc.$item->getName()) > 100) {
                break;
            }
            $invoiceDesc .= $item->getName() . ', ';
        }
        return Mage::helper('core/string')->substr($invoiceDesc, 0, -2);
    }

    /**
     * Define if debugging is enabled
     *
     * @return bool
     */
    public function getDebugFlag()
    {
        return $this->getConfigData('debug_flag');
    }

    /**
     * Transform collected data array to <value1><value2><...><passPhrase> according to the provided map
     *
     * @param array $data
     * @param string $passPhrase
     * @param string $hashMap
     * @return string
     */
    protected function _concatenateBasic($data, $passPhrase, $hashMap)
    {
        $result = '';
        foreach (self::$$hashMap as $key) {
            if (isset($data[$key])) {
                $result .= $data[$key];
            }
        }
        return $result . $passPhrase;
    }

    /**
     * Transform collected data array to <KEY>=<value><passPhrase>
     *
     * @param array $data
     * @param string $passPhrase
     * @return string
     */
    protected function _concatenateAdvanced($data, $passPhrase)
    {
        $result = '';
        foreach ($data as $key => $value) {
            $result .= "{$key}={$value}{$passPhrase}";
        }
        return $result;
    }
}
