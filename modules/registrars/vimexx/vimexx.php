<?php

/**
 * Check WHMCS is defined
 */
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Domains\DomainLookup\ResultsList;
use WHMCS\Domains\DomainLookup\SearchResult;

require('connect.php');

/**
 * Set module metadata
 *
 * @return array
 */
function vimexx_MetaData()
{
    return array(
        'DisplayName' => 'Vimexx REST API Module for WHMCS',
        'APIVersion' => '1.1.1',
    );
}

/**
 * Set vimexx module config settings
 *
 * @return array
 */
function vimexx_getConfigArray($params)
{
    return array(
        'ClientID' => array(
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Enter your client ID',
        ),
        'ClientKey' => array(
            'Type' => 'text',
            'Size' => '100',
            'Default' => '',
            'Description' => 'Enter your key',
        ),
        'Username' => array(
            'Type' => 'text',
            'Size' => '100',
            'Default' => '',
            'Description' => 'Enter your username',
        ),
        'Password' => array(
            'Type' => 'password',
            'Size' => '100',
            'Default' => '',
            'Description' => 'Enter your password ',
        ),
        'ApiUrl' => array(
            'Type' => 'text',
            'Size' => '100',
            'Default' => '',
            'Description' => 'API URL',
        ),
        'Site-version' => array(
            'Type' => 'dropdown',
            'Options' => array(
                '.nl' => 'NL',
            ),
            'Description' => 'Choose which Vimexx API you want to connect to',
        ),
        'TestMode' => array(
            'Type' => 'dropdown',
            'Options' => array(
                'true' => 'On',
                'false' => 'Off',
            ),
            'Description' => 'Choose one',
        ),
        'VersionWhmcs' => array(
            'Type' => 'text',
            'Size' => '100',
            'Default' => $params['whmcsVersion'],
            'Description' => '<b>NIET AANPASSEN!</b>',
        ),
    );
}

/**
 * Register a new domain
 *
 * @param $params
 * @return array
 */
function vimexx_RegisterDomain($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('POST', '/whmcs/domain/register', [
        'sld' => $sld,
        'tld' => $tld
    ], $params['VersionWhmcs']);

    if(!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        return array(
            'success' => true,
        );
    }
}

/**
 * Transfer a domain
 *
 * @param $params
 * @return array
 */
function vimexx_TransferDomain($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];
    $token      = $params['eppcode'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('POST', '/whmcs/domain/transfer', [
        'sld'   => $sld,
        'tld'   => $tld,
        'token' => $token
    ], $params['VersionWhmcs']);

    if(!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        return array(
            'success' => true,
        );
    }
}

/**
 * Renew a domain
 *
 * @param $params
 * @return array
 */
function vimexx_RenewDomain($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('POST', '/whmcs/domain/extend', [
        'sld' => $sld,
        'tld' => $tld
    ], $params['VersionWhmcs']);

    if(!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        return array(
            'success' => true,
        );
    }
}

/**
 * Request delete a domain
 *
 * @param $params
 * @return array
 */
function vimexx_RequestDelete($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('DELETE', '/whmcs/domain/', [
        'sld' => $sld,
        'tld' => $tld
    ], $params['VersionWhmcs']);

    if(!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        return array(
            'success' => true,
        );
    }
}

/**
 * Request the nameservers
 *
 * @param $params
 * @return array
 */
function vimexx_GetNameservers($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('POST', '/whmcs/domain/nameservers', [
        'sld' => $sld,
        'tld' => $tld
    ], $params['VersionWhmcs']);

    if (!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        return array(
            'dnsmanagement' => 1,
            'success' => true,
            'ns1' => (isset($response['data']['ns1'])) ? $response['data']['ns1'] : '',
            'ns2' => (isset($response['data']['ns2'])) ? $response['data']['ns2'] : '',
            'ns3' => (isset($response['data']['ns3'])) ? $response['data']['ns3'] : '',
            'ns4' => (isset($response['data']['ns4'])) ? $response['data']['ns4'] : '',
            'ns5' => (isset($response['data']['ns5'])) ? $response['data']['ns5'] : '',
        );
    }
}

/**
 * Save nameservers
 *
 * @param $params
 * @return array
 */
function vimexx_SaveNameservers($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $nameservers    = array();

    if(!$params['ns1'] == null) {
        $nameservers[] = array('ns' => $params['ns1']);
    }

    if(!$params['ns2'] == null) {
        $nameservers[] = array('ns' => $params['ns2']);
    }

    if(!$params['ns3'] == null) {
        $nameservers[] = array('ns' => $params['ns3']);
    }

    if(!$params['ns4'] == null) {
        $nameservers[] = array('ns' => $params['ns4']);
    }

    if(!$params['ns5'] == null) {
        $nameservers[] = array('ns' => $params['ns5']);
    }

    $response = $vimexx->request('PUT', '/whmcs/domain/' . $sld . '.' . $tld . '/nameservers', [
        'sld'           => $sld,
        'tld'           => $tld,
        'nameservers'   => $nameservers,
        'name'          => 'whmcs-' . $sld . '.' . $tld
    ], $params['VersionWhmcs']);

    if (!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        return array('success' => true);
    }
}

/**
 * Fetch domain DNS records
 *
 * @param $params
 * @return array
 */
function vimexx_GetDNS($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('POST', '/whmcs/domain/dns', [
        'sld'           => $sld,
        'tld'           => $tld,
    ], $params['VersionWhmcs']);

    if (!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        $hostRecords    = array();
        $records        = count($response['data']['dns_records']);

        $i = 0;
        do {
            $hostRecords[] = array(
                "hostname"      => $response['data']['dns_records'][$i]['name'],
                "type"          => $response['data']['dns_records'][$i]['type'],
                "address"       => $response['data']['dns_records'][$i]['content'],
                "priority"      => $response['data']['dns_records'][$i]['prio'],
            );

            $i++;
        } while ($i < $records);

        return $hostRecords;
    }
}

/**
 * Save the DNS records
 *
 * @param $params
 * @return array
 */
function vimexx_SaveDNS($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $dnsRecords         = array();

    foreach($params['dnsrecords'] as $dnsrecord) {
        if ($dnsrecord['type'] == 'MXE') {
            return array('error' => 'Record type MXE is not supported');
        } elseif($dnsrecord['type'] == 'FRAME') {
            return array('error' => 'Record type FRAME is not supported');
        } elseif($dnsrecord['type'] == 'URL') {
            return array('error' => 'Record type URL is not supported');
        } else {
            if (!$dnsrecord['hostname'] == NULL) {
                if ($dnsrecord['priority'] == 'N\/A') {
                    $dnsrecord['priority'] = 0;
                }

                $dnsRecords[] = array(
                    'type'      => $dnsrecord['type'],
                    'name'      => $dnsrecord['hostname'],
                    'content'   => $dnsrecord['address'],
                    'prio'      => (int)$dnsrecord['priority'],
                    'ttl'       => 3600
                );
            }
        }
    }

    $response = $vimexx->request('PUT', '/whmcs/domain/dns', [
        'sld'           => $sld,
        'tld'           => $tld,
        'dns_records'   => $dnsRecords
    ], $params['VersionWhmcs']);

    if (!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        return array('success' => 'success');
    }
}

/**
 * Request domain EPP code
 *
 * @param $params
 * @return array
 */
function vimexx_GetEPPCode($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('POST', '/whmcs/domain/token', [
        'sld' => $sld,
        'tld' => $tld
    ], $params['VersionWhmcs']);

    if(!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } elseif (!empty($response['data'])) {
        return array(
            'eppcode' => $response['data'],
        );
    } else {
        return array(
            'success' => true,
        );
    }
}

/**
 * Sync expiration date and status with WHMCS
 *
 * @param $params
 * @return array
 */
function vimexx_Sync($params)
{
    $clientId       = $params['ClientID'];
    $clientKey      = $params['ClientKey'];
    $username       = $params['Username'];
    $password       = $params['Password'];
    $apiUrl         = $params['ApiUrl'];
    $endpoint       = $params['Site-version'];
    $testmode       = $params['TestMode'];
    $versionWhmcs   = $params['VersionWhmcs'];
    $sld            = $params['sld'];
    $tld            = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('POST', '/whmcs/domain/sync', [
        'sld' => $sld,
        'tld' => $tld
    ], $versionWhmcs);

    if(!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        $status         = $response['data']['status'];
        $dnsManagement  = $response['data']['dnsManagement'];

        switch ($status) {
            case "ok":
                return array(
                    'dnsmanagement'     => $dnsManagement,
                    'expirydate'        => $response['data']['expireDate'],
                    'active'            => true
                );
                break;

            case "free":
                return array('active' => false);
                break;

            default:
                return array(
                    'dnsmanagement' => $dnsManagement,
                    'expirydate'    => $response['data']['expireDate'],
                    'active'        => false
                );
                break;
        }
    }
}

/**
 * Sync transfer status
 *
 * @param $params
 * @return array
 */
function vimexx_TransferSync($params)
{
    $clientId       = $params['ClientID'];
    $clientKey      = $params['ClientKey'];
    $username       = $params['Username'];
    $password       = $params['Password'];
    $apiUrl         = $params['ApiUrl'];
    $endpoint       = $params['Site-version'];
    $testmode       = $params['TestMode'];
    $versionWhmcs   = $params['VersionWhmcs'];
    $sld            = $params['sld'];
    $tld            = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response = $vimexx->request('POST', '/whmcs/domain/sync/transfer', [
        'sld' => $sld,
        'tld' => $tld
    ], $versionWhmcs);

    if(!$response['result']) {
        $message = $response['message'];

        if (is_array($response['message'])) {
            $message = implode("\r\n", $response['message']);
        }

        return array('error' => $message);
    } else {
        $status = $response['data']['status'];

        switch ($status) {
            case "ok":
                return array(
                    'completed'         => true,
                    'expirydate'        => $response['expireDate'],
                );
                break;

            default:
                return array();
                break;
        }
    }
}

/**
 * Custom contact buttons
 *
 * @return array
 */
function vimexx_ClientAreaCustomButtonArray()
{
    return array(
        'Contact modify details' => 'ContactModify',
        'Contact apply to domain' => 'ContactApply',
    );
}

/**
 * Custom contact apply function
 *
 * @param $params
 * @return array
 */
function vimexx_ContactApply($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $response       = $vimexx->request('POST', '/whmcs/domain/contacts', [
        'sld'           => $sld,
        'tld'           => $tld,
    ], $params['VersionWhmcs']);

    $responseCheck  = $vimexx->request('POST', '/whmcs/domain/contact/checkJob', [
        'sld'           => $sld,
        'tld'           => $tld,
    ], $params['VersionWhmcs']);

    $contacts       = ($response['result'] && !empty($response['data'])) ? $response['data']: [];

    return array(
        'templatefile' => 'contactapply',
        'breadcrumb' => array(
            'clientarea.php?action=domaindetails&id=' . $params['domainid'] . '&modop=custom&a=ContactApply' => 'Contacts apply to domain',
        ),
        'vars' => array(
            'contacts'      => $contacts,
            'customAction'  => 'SaveContactApply',
            'domainSld'     => $sld,
            'domainTld'     => $tld,
            'jobMsg'        => (!$responseCheck['result']) ? $responseCheck['message'] : '',
            'hasJob'        => (!$responseCheck['result']) ? true : false,
        ),
    );
}

/**
 * Save the contact apply settings
 *
 * @param $params
 * @param $requestParams
 * @return string
 */
function vimexx_SaveContactApply($params, $requestParams)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $contacts               = [];
    $contacts['registrant'] = $requestParams['contact_registrant'];
    $contacts['admin']      = $requestParams['contact_admin'];
    $contacts['billing']    = $requestParams['contact_billing'];
    $contacts['tech']       = $requestParams['contact_technical'];
    $contacts['tech2']      = $requestParams['contact_technical2'];

    $response = $vimexx->request('PUT', '/whmcs/domain/contacts', [
        'sld'           => $sld,
        'tld'           => $tld,
        'contacts'      => $contacts
    ], $params['VersionWhmcs']);

    global $smarty;

    if (!$response['result'])  {
        $smarty->assign('errorMsg', $response['message']);
        $smarty->assign('hasError', true);
        return;
    }

    $smarty->assign('successful', true);
}

/**
 * Modify a specific contact
 *
 * @param $params
 * @return array
 */
function vimexx_ContactModify($params)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $responseCountries  = $vimexx->request('POST', '/whmcs/countries', [], $params['VersionWhmcs']);
    $response           = $vimexx->request('POST', '/whmcs/domain/contacts', [
        'sld'           => $sld,
        'tld'           => $tld,
    ], $params['VersionWhmcs']);

    $contacts   = ($response['result'] && !empty($response['data'])) ? $response['data']: [];
    $countries  = ($responseCountries['result'] && !empty($responseCountries['data'])) ? $responseCountries['data'] : [];

    return array(
        'templatefile' => 'contactmodify',
        'breadcrumb' => array(
            'clientarea.php?action=domaindetails&id=' . $params['domainid'] . '&modop=custom&a=ContactModify' => 'Contact modify details',
        ),
        'vars' => array(
            'contacts' => $contacts,
            'countries' => $countries,
            'customAction' => 'SaveContactModify',
            'contactsJson' => json_encode($contacts),
            'domainSld' => $sld,
            'domainTld' => $tld,
        ),
    );

}

/**
 * Save modified contact
 *
 * @param $params
 * @param $requestParams
 * @return array
 */
function vimexx_SaveContactModify($params, $requestParams)
{
    $clientId   = $params['ClientID'];
    $clientKey  = $params['ClientKey'];
    $username   = $params['Username'];
    $password   = $params['Password'];
    $apiUrl     = $params['ApiUrl'];
    $endpoint   = $params['Site-version'];
    $testmode   = $params['TestMode'];
    $sld        = $params['sld'];
    $tld        = $params['tld'];

    $vimexx     = new Vimexx_API();
    $vimexx->setApi_login($clientId, $clientKey, $username, $password, $apiUrl, $endpoint);
    $vimexx->setApi_testmodus($testmode);

    $contact = [
        'id'            => $requestParams['contact_id'],
        'firstname'     => $requestParams['firstname'],
        'lastname'      => $requestParams['lastname'],
        'company'       => $requestParams['company'],
        'email'         => $requestParams['email'],
        'street'        => $requestParams['street'],
        'housenumber'   => $requestParams['housenumber'],
        'city'          => $requestParams['city'],
        'zipcode'       => $requestParams['zipcode'],
        'country'       => $requestParams['country'],
        'phone'         => $requestParams['phone'],
        'fax'           => $requestParams['fax'],
    ];

    if (isset($requestParams['extra_options']) && count($requestParams['extra_options'])) {
        $contact = array_merge($contact, $requestParams['extra_options']);
    }

    $response = $vimexx->request('PUT', '/whmcs/domain/contact', [
        'sld'           => $sld,
        'tld'           => $tld,
        'contact'       => $contact,
    ], $params['VersionWhmcs']);

    global $smarty;

    if (!$response['result'])  {
        if (is_array($response['message'])) {
            $result = array();

            array_walk_recursive($response['message'],function($v, $k) use (&$result) {
                $result[] = $v;
            });

            $smarty->assign('errorMsg', implode('<br />', $result   ));
        } else {
            $smarty->assign('errorMsg', $response['message']);
        }

        $smarty->assign('hasError', true);
        return;
    }

    $smarty->assign('successful', true);
    return;
}

/**
 * Handle custom functions
 *
 * @param array $params
 * @return string
 */
function vimexx_ClientArea(array $params)
{
    $requestedAction = isset($_REQUEST['customAction']) ? $_REQUEST['customAction'] : '';

    switch ($requestedAction) {
        case 'SaveContactModify':
            return vimexx_SaveContactModify($params, $_REQUEST);
            break;

        case 'SaveContactApply':
            return vimexx_SaveContactApply($params, $_REQUEST);
            break;
    }
}