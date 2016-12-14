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

namespace CorreiosAPI\Tracker;

class ResponseCodes
{
  /**
   * Readable messages for the packages codes/statuses
   * @var array
   */
  protected static $responseCodes = [
      0  => 'Postado'
    , 1  => 'Entregue'
    , 2  => 'Destinatário ausente'
    , 3  => 'Não procurado'
    , 4  => 'Recusado'
    , 5  => 'Em devolução'
    , 6  => 'Destinatário desconhecido no endereço'
    , 7  => 'Endereço insuficiente para entrega'
    , 8  => 'Não existe o número indicado'
    , 9  => 'Extraviado'
    , 10 => 'Destinatário mudou-se'
    , 11 => 'Outros'
    , 12 => 'Refugado'
    , 14 => 'Aguardando retirada'
    , 15 => 'Conferido'
    , 16 => 'Conferido'
    , 17 => 'Conferido'
    , 18 => 'Conferido'
    , 19 => 'Endereço incorreto'
    , 20 => 'Destinatário ausente'
    , 21 => 'Destinatário ausente'
    , 22 => 'Reintegrado'
    , 23 => 'Distribuído ao remetente'
    , 24 => 'Disponível em caixa postal'
    , 25 => 'Empresa sem expediente'
    , 26 => 'Não procurado'
    , 27 => 'Pedido não solicitado'
    , 28 => 'Mercadoria avariada'
    , 31 => 'Extraviado'
    , 32 => 'Entrega programada'
    , 33 => 'Documentação não fornecida pelo destinatário'
    , 34 => 'Logradouro com numeração irregular - Em pesquisa'
    , 35 => 'Logística reversa simultânea'
    , 36 => 'Logística reversa simultânea'
    , 40 => 'Devolvido ao remetente'
    , 41 => 'Aguardando parte do lote'
    , 42 => 'Devolvido ao remetente'
    , 43 => 'Objeto apreendido por autoridade competente'
    , 44 => 'Falta documento para liberação para retirada interna'
    , 45 => 'Resíduo de mesa'
    , 46 => 'Entrega não efetuada'
    , 47 => 'Erro de lançamento'
    , 50 => 'Roubo a carteiro'
    , 51 => 'Roubo a veículo'
    , 52 => 'Roubo a unidade'
    , 54 => 'Aguardando pagamento de ICMS de importação'
    , 55 => 'Solicitada revisão do tributo'
    , 56 => 'Declaração aduaneira ausente ou incorreta'
    , 57 => 'Revisão de tributo concluída - Objeto liberado'
    , 58 => 'Revisão de tributo concluída - Tributo alterado'
    , 59 => 'Revisão de tributo concluída - Tributo mantido'
    , 66 => 'Área com distribuição sujeita a prazo diferenciado'
    , 69 => 'Objeto com atraso na entrega'
    , 'CAR' => 'Conferido'
    , 'CD'  => 'Conferido'
    , 'CMR' => 'Conferido'
    , 'CO'  => 'Conferido'
    , 'CUN' => 'Conferido'
    , 'DO'  => 'Encaminhado'
    , 'EST' => 'Estornado'
    , 'FC'  => [
          1 => 'Devolvido a pedido do cliente'
        , 2 => 'Com entrega agendada'
        , 3 => 'Mal encaminhado'
        , 4 => 'Mal endereçado'
        , 5 => 'Reintegrado'
        , 6 => 'Restrição lançamento externo'
        , 7 => 'Empresa sem expediente'
      ]
    , 'IDC' => 'Indenizado'
    , 'IE'  => 'Irregularidade na expedição'
    , 'IT'  => 'Passagem interna'
    , 'LDI' => [
          1 => 'Aguardando retirada'
        , 2 => 'Caixa postal'
        , 8 => 'Fiscalização'
      ]
    , 'OEC' => 'Saiu para entrega'
    , 'PMT' => 'Partiu em meio de transporte'
    , 'PO'  => 'Postado'
    , 'RO'  => [
          1  => 'Encaminhado'
        , 99 => 'Encaminhado (estornado)'
      ]
    , 'TR'  => 'Trânsito'
  ];

  /**
   * Returns a readable message of the current package status
   * @param  string $code   The status code (2-3 letters code)
   * @param  string $status The status number (1-2 digits)
   * @return string
   */
  public static function getMessage($code, $status)
  {
    $code   = strval($code);
    $status = intval($status);

    if (array_key_exists($code, self::$responseCodes)) {
      // Returns $responseCodes[$code][$status]
      if (is_array(self::$responseCodes[$code]) && array_key_exists($status, self::$responseCodes[$code])) {
        return self::$responseCodes[$code][$status];
      }

      // Returns $responseCodes[$code] if it's a string, otherwise implodes it and returns
      if (is_array(self::$responseCodes[$code])) {
        return implode(' - ', self::$responseCodes[$code]);
      }

      return self::$responseCodes[$code];
    }

    // Returns by status if there is no code
    if (isset(self::$responseCodes[$status])) {
      return self::$responseCodes[$status];
    }

    return "Desconhecido ({$code}-{$status})";
  }
}

