<?php

use CorreiosAPI\Tracker\ResponseCodes;

class ResponseCodesTest extends TestCase
{
  public function testMessageNotFound()
  {
    $message = ResponseCodes::getMessage('FOO', 100);
    $this->assertEquals('Desconhecido (FOO-100)', $message);
  }

  public function testMessageFoundWithCodeAndStatus()
  {
    $message = ResponseCodes::getMessage('FC', 3);
    $this->assertEquals('Mal encaminhado', $message);
  }

  public function testMessageFoundWithCodeOnly()
  {
    $message = ResponseCodes::getMessage('OEC', 1823712873812);
    $this->assertEquals('Saiu para entrega', $message);
  }

  public function testMessageFoundWithStatusOnly()
  {
    $message = ResponseCodes::getMessage('BRHUEHUEHUE', 50);
    $this->assertEquals('Roubo a carteiro', $message);
  }

  public function testMessageFoundWithCodeAndNoStatus()
  {
    $message = ResponseCodes::getMessage('LDI', null);
    $this->assertEquals('Aguardando retirada - Caixa postal - Fiscalização', $message);
  }
}
