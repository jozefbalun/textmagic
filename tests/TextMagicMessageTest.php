<?php
namespace NotificationChannels\TextMagic\Test;

use NotificationChannels\TextMagic\TextMagicMessage;

class TextMagicMessageTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function itAcceptsContentWhenConstructed()
    {
        $message = new TextMagicMessage('Laravel Notification Channels are awesome!');
        $this->assertEquals('Laravel Notification Channels are awesome!', $message->payload['text']);
    }


    /** @test */
    public function itAcceptsStaticTextMagicMessage()
    {
        $message = TextMagicMessage::create('Laravel Notification Channels are awesome!');
        $this->assertEquals('Laravel Notification Channels are awesome!', $message->payload['text']);
    }


    /** @test */
    public function theRecipientsPhoneNumberCanBeSet()
    {
        $message = new TextMagicMessage();
        $message->to('12345');
        $this->assertEquals(true, in_array('12345', $message->payload['phones']));
    }


    /** @test */
    public function theNotificationMessageCanBeSet()
    {
        $message = new TextMagicMessage();
        $message->content('Laravel Notification Channels are awesome!');
        $this->assertEquals('Laravel Notification Channels are awesome!', $message->payload['text']);
    }


    /** @test */
    public function theNotificationFromCanBeSet()
    {
        $message = new TextMagicMessage();
        $message->from('12345');
        $this->assertEquals('12345', $message->payload['from']);
    }


    /** @test */
    public function itCanDetermineIfTheRecipientPhoneHasNotBeenSet()
    {
        $message = new TextMagicMessage();
        $this->assertTrue($message->toNotGiven());
        $message->to('12345');
        $this->assertFalse($message->toNotGiven());
    }


    /** @test */
    public function itCanReturnThePayloadAsAnArray()
    {
        $message = new TextMagicMessage('Laravel Notification Channels are awesome!');
        $message->to('12345');
        $message->from('54321');
        $expected = [
            "text" => "Laravel Notification Channels are awesome!",
            "phones" => '12345',
            "from" => '54321',
        ];
        $this->assertEquals($expected, $message->toArray());
    }
}
