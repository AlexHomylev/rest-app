<?php

namespace tests\codeception\components;

use Codeception\Exception\ModuleException;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\DomCrawler\Field\ChoiceFormField;

/**
 * Модуль PhpBrowser для Codeception.
 */
class PhpBrowser extends \Codeception\Module\PhpBrowser
{
    /**
     * В модуле переопределен метод для функциональных тестов где есть список с множественным выбором.
     * @param $select
     * @param $option
     */
    public function selectOption($select, $option)
    {
        $field = $this->getFieldByLabelOrCss($select);
        $form = $this->getFormFor($field);
        $fieldName = parent::getSubmissionFormFieldName($field->attr('name'));

        if (\is_array($option)) {
            $options = [];
            foreach ($option as $opt) {
                $options[] = $this->matchOption($field, $opt);
            }
            $form[$fieldName]->select($options);
            return;
        }

        $dynamicField = new ChoiceFormField($field->getNode(0));
        $formField = parent::matchFormField($fieldName, $form, $dynamicField);
        $selValue = $this->matchOption($field, $option);

        if (\is_array($formField)) {
            foreach ($formField as $field) {
                $values = $field->availableOptionValues();
                foreach ($values as $val) {
                    if ($val === $option) {
                        $field->select($selValue);
                        return;
                    }
                }
            }
            return;
        }

        $formField->select($this->matchOption($field, $option));
    }

    /**
     * Получить запущеный клиент.
     *
     * @return \Codeception\Lib\Connector\Guzzle6|\Symfony\Component\BrowserKit\Client
     * @throws ModuleException
     */
    private function getRunningClient()
    {
        if ($this->client->getInternalRequest() === null) {
            throw new ModuleException(
                $this,
                'Page not loaded. Use `$I->amOnPage` (or hidden API methods `_request` and `_loadPage`) to open it'
            );
        }
        return $this->client;
    }

    /**
     * Получить все куки.
     *
     * @return array
     * @throws ModuleException
     */
    public function getCookies()
    {
        $cookieJar = $this->getRunningClient()->getCookieJar();
        return $cookieJar->all();
    }

    /**
     * Куки.
     *
     * @param string $name название
     *
     * @return null|Cookie
     * @throws ModuleException
     */
    public function getCookie($name)
    {
        $cookies = $this->getCookies();

        $result = null;
        foreach ($cookies as $cookie) {
            if ($cookie->getName() === $name) {
                $result = $cookie;
            }
        }
        return $result;
    }

    /**
     * Получить домен куки.
     *
     * @param string $name название
     *
     * @return null|string
     * @throws ModuleException
     */
    public function getCookieDomain($name)
    {
        $result = null;
        if ($cookie = $this->getCookie($name))
        {
            $result = $cookie->getDomain();
        }

        return $result;
    }
}
