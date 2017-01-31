<?php

/**
 * Copyright (c) 2014, Gustavo Henrique Mascarenhas Machado
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * * Neither the name of CorreiosAPI nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace CorreiosAPI;

use Exception;
use InvalidArgumentException;
use RuntimeException;
use GuzzleHttp\Client as HttpClient;

class Tracker
{
  /**
   * Webservice endpoint
   */
  const WEBSERVICE_URL = 'https://webservice.correios.com.br/service/rastro/Rastro.wsdl';

  /**
   * Fetches a single package
   */
  const FETCH_SINGLE = 'L';

  /**
   * Fetches an interval of packages
   */
  const FETCH_INTERVAL = 'F';

  /**
   * The results mode. 'T' will return the entire package history.
   */
  const RESULT_MODE = 'T';

  /**
   * Webservice username, supplied by Correios
   * @var string
   */
  protected $username;

  /**
   * Webservice password, supplied by Correios
   * @var string
   */
  protected $password;


  /**
   * Sets up user credentials
   * @param  string $username Webservice username
   * @param  string $password Webservice password
   */
  public function __construct($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
  }

  /**
   * Validates the format of a tracking number
   * @param  string $trackingNumber The tracking number
   * @return boolean
   */
  protected function validTrackingNumber($trackingNumber)
  {
    if (preg_match('/^[\D]{2}[\d]{9}[\D]{2}$/i', $trackingNumber)) {
      return true;
    }

    throw new InvalidArgumentException("{$trackingNumber} is not a valid tracking number in the format XX000000000YY.");
  }

  /**
   * Tracks one or more packages
   * @param  mixed $trackingNumber A single tracking number or an array of tracking numbers
   * @return mixed
   */
  public function track($trackingNumber)
  {
    if (is_array($trackingNumber)) {
      throw new \RuntimeException('Only a single tracking number can be processed at a time.');
    }

    $trackingNumber = strtoupper($trackingNumber);

    $this->validTrackingNumber($trackingNumber);

    return $this->queryAPI($trackingNumber, self::FETCH_SINGLE);
  }

  /**
   * Queries the Correios webservice
   * @param  string $trackingNumbers A collection of tracking numbers
   * @param  string $fetchMode       The fetch mode (for one or more tracking numbers)
   * @return mixed
   */
  protected function queryAPI($trackingNumbers, $fetchMode)
  {
    $params = [
        'usuario'   => $this->username
      , 'senha'     => $this->password
      , 'tipo'      => $fetchMode
      , 'resultado' => self::RESULT_MODE
      , 'objetos'   => $trackingNumbers
      , 'lingua'    => '101'
    ];

    try {
      $client = new \SoapClient(self::WEBSERVICE_URL);
      $response = $client->buscaEventos($params);

      if (!$response || empty($response)) {
        return false;
      }

      return $this->processResponse($response);
    } catch (Exception $e) {
      throw new RuntimeException($e->getMessage());
    }

    return false;
  }

  /**
   * Processes the webservice response and builds a readable associative
   * array of the events associated to one or more packages
   * @param  string $responseBody The response body (xml)
   * @return mixed
   */
  protected function processResponse($responseBody)
  {
    $response = $responseBody->{'return'};

    if (!$response || $response->objeto->erro) {
      return false;
    }

    $results = [];
    $events = [];

    foreach ($response->objeto->evento as $event) {
      $events[] = [
          'when'    => $event->data . ' ' . $event->hora
        , 'where'   => strtoupper($event->local . (strlen($event->cidade) ? (' - ' . $event->cidade . '/' . $event->uf) : ''))
        , 'action'  => Tracker\ResponseCodes::getMessage($event->tipo, $event->status)
        , 'details' => (string) $event->descricao
      ];
    }

    $trackingNumber = (string) $response->objeto->numero;
    $results[$trackingNumber] = $events;

    return $results;
  }
}
