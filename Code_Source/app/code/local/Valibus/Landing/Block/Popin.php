<?php
class Valibus_Landing_Block_Popin extends Mage_Core_Block_Template
{
    const COOKIE_NAME = 'landing';

    //test if we show the popin (and the HTML & JS source code also)
    public function canShow()
    {

        //on vérifie si le cookie existe
        if ($this->readCookie()) {
            $cookieLanding = $this->readCookie();
            $cookieSetOn = $cookieLanding[0];
            $cookieDisplay = $cookieLanding[1];
            //on test si il n'est expiré
            if (Mage::helper('valibus_landing')->getShowAgain($cookieSetOn)) {
                $this->startCookie();
                return true;
            } elseif (Mage::helper('valibus_landing')->getShowFirst($cookieSetOn, $cookieDisplay)) {
                $this->updateCookie();
                return true;
            } else {
                return false;
            }
        } else {
            $this->startCookie();
            return false;
        }
    }

    //Set cookie

    public function startCookie()
    {
        $cookie = Mage::getModel('core/cookie');
        $value = time() . '.'.'0';
        $cookie->set(self::COOKIE_NAME, $value, Mage::helper('valibus_landing')->getRepeatDelay());
        return $cookie;
    }

    public function updateCookie()
    {
        $infos = $this->readCookie();
        $cookie = Mage::getModel('core/cookie');
        $value = $infos[0] . '.'.'1';
        $cookie->set(self::COOKIE_NAME, $value, Mage::helper('valibus_landing')->getRepeatDelay());
        return $cookie;
    }

    public function readCookie()
    {
        $landingCookie = Mage::getModel('core/cookie');
        if ($landingCookie->get(self::COOKIE_NAME)) {
            $landingInfos = explode('.', $landingCookie->get(self::COOKIE_NAME));
        } else {
            return false;
        }
        return $landingInfos;
    }
    public function getContent()
    {
        return Mage::helper('valibus_landing')->getDisplayContent();
    }
}