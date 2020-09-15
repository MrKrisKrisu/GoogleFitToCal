<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class UnitTest extends TestCase
{

    private $dummyJson = '  {
                              "session": [
                                {
                                  "id": "afdadb69843ebb0a73ac8b1e79ebcaa8",
                                  "name": "Sleep",
                                  "description": "",
                                  "startTimeMillis": "1596410646685",
                                  "endTimeMillis": "1596429686169",
                                  "modifiedTimeMillis": "1597638294721",
                                  "application": {
                                    "packageName": "com.urbandroid.sleep"
                                  },
                                  "activityType": 72
                                }
                              ],
                              "deletedSession": [],
                              "nextPageToken": "XmdhydiVvSV54IX8xi9jZQ"
                            }';

    public function testDummyIsValidJson(): void
    {
        $this->assertIsObject(
            json_decode($this->dummyJson)
        );
    }

    public function testIcsCanBeParsedFromValidJson(): void
    {
        $parser = new GoogleFitToCal\GoogleFitToCal('token');

        $this->assertIsString(
            $parser->parseData('example.org', json_decode($this->dummyJson))
        );
    }


    public function testDateTimeIsParsedCorrectly(): void
    {
        $parser = new GoogleFitToCal\GoogleFitToCal('token');
        $ics = $parser->parseData('example.org', json_decode($this->dummyJson));

        $this->assertStringContainsString('DTSTART:20200802T232406Z', $ics);
        $this->assertStringContainsString('DTEND:20200803T044126Z', $ics);
        $this->assertStringContainsString('SUMMARY:Sleep', $ics);
        $this->assertStringContainsString('PRODID:example.org', $ics);
    }
}
