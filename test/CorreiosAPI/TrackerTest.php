<?php

use CorreiosAPI\Tracker;

class TrackerTest extends TestCase
{
  protected $tracker = null;

  public function setup()
  {
    $this->tracker = new Tracker('NOT', 'VALID');
  }

  /**
   * @expectedException              InvalidArgumentException
   * @expectedExceptionMessageRegExp /is not a valid tracking number/
   */
  public function testTrackingNumberIsInvalid1()
  {
    $this->tracker->track('STRINGS');
  }

  /**
   * @expectedException              InvalidArgumentException
   * @expectedExceptionMessageRegExp /is not a valid tracking number/
   */
  public function testTrackingNumberIsInvalid2()
  {
    $this->tracker->track('123456');
  }

  /**
   * @expectedException              InvalidArgumentException
   * @expectedExceptionMessageRegExp /is not a valid tracking number/
   */
  public function testTrackingNumberIsInvalid3()
  {
    $this->tracker->track('0012345678900');
  }

  /**
   * @expectedException              InvalidArgumentException
   * @expectedExceptionMessageRegExp /is not a valid tracking number/
   */
  public function testTrackingNumberIsInvalid4()
  {
    $this->tracker->track('RRXXXXXXXXXEE');
  }

  /**
   * @expectedException              InvalidArgumentException
   * @expectedExceptionMessageRegExp /is not a valid tracking number/
   */
  public function testTrackingNumberIsInvalid5()
  {
    $this->tracker->track('RR1234567890E');
  }

  /**
   * Bad test, API call should be mocked
   * @TODO: mock api call
   * @expectedException              RuntimeException
   */
  public function testTrackingNumberIsValidButCredentialsAreNot()
  {
    $this->tracker->track('RR123456789EE');
  }

  /**
   * @TODO: mock api call
   */
  public function testApiResponseProcessingIsSuccessful()
  {
    $goodResponse = '{}';
  }

  /**
   * @TODO: mock api call
   * @expectedException              RuntimeException
   * @expectedExceptionMessageRegExp /API call error/
   */
  public function testApiResponseProcessingIsUnsuccessful()
  {
    $badResponse = '<?xml version="1.0" encoding="iso-8859-1" ?>
                    <sroxml>
                       <versao>1.0</versao>
                         <error>falha na autenticao do usuio</error>
                    </sroxml>';
  }
}
