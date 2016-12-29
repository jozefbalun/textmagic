<?php
namespace NotificationChannels\TextMagic\Test;

use Mockery;
use Illuminate\Notifications\Notification;
use NotificationChannels\TextMagic\Exceptions\CouldNotSendNotification;
use NotificationChannels\TextMagic\TextMagicChannel;
use NotificationChannels\TextMagic\TextMagic;
use NotificationChannels\TextMagic\TextMagicMessage;
use Orchestra\Testbench\TestCase;

class TextMagicChannelTest extends TestCase
{

    /** @var Mockery\Mock */
    protected $textMagix;

    /** @var \NotificationChannels\TextMagic\TextMagicChannel */
    protected $channel;


    public function setUp()
    {
        parent::setUp();
        $this->textMagix = Mockery::mock(TextMagic::class);
        $this->channel = new TextMagicChannel($this->textMagix);
    }


    /** @test */
    public function itCanSendAMessage()
    {
        $this->textMagix->shouldReceive('sendMessage')->once()->with([
            'text' => 'Laravel Notification Channels are awesome!',
            'phones' => '12345',
        ]);
        $this->channel->send(new TestNotifiable(), new TestNotification());
    }


    /** @test */
    public function itThrowsAnExceptionWhenItCouldNotSendTheNotificationBecauseNoPhoneProvided()
    {
        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send(new TestNotifiable(), new TestNotificationNoPhone());
    }


    /** @test */
    public function itCouldSendTheNotificationFromUserPhoneWhenIsProvided()
    {
        $this->textMagix->shouldReceive('sendMessage')->once()->with([
            'text' => '',
            'phones' => '12345',
        ]);
        $this->channel->send(new TestNotifiableTrue(), new TestNotificationNoPhone());
    }


    /** @test */
    public function itCouldSendTheNotificationWhenNotifiableIsString()
    {
        $this->textMagix->shouldReceive('sendMessage')->once()->with([
            'text' => 'some string',
            'phones' => '12345',
        ]);
        $this->channel->send(new TestNotifiableTrue(), new TestNotificationStringReturn());
    }
}

class TestNotifiable
{

    use \Illuminate\Notifications\Notifiable;


    /**
     * @return boolean
     */
    public function routeNotificationForTextMagic()
    {
        return false;
    }
}

class TestNotifiableTrue
{

    use \Illuminate\Notifications\Notifiable;


    /**
     * @return string
     */
    public function routeNotificationForTextMagic()
    {
        return '12345';
    }
}

class TestNotification extends Notification
{

    public function toTextMagic($notifiable)
    {
        return TextMagicMessage::create('Laravel Notification Channels are awesome!')->to('12345');
    }
}

class TestNotificationNoPhone extends Notification
{

    public function toTextMagic($notifiable)
    {
        return TextMagicMessage::create();
    }
}

class TestNotificationStringReturn extends Notification
{

    public function toTextMagic($notifiable)
    {
        return 'some string';
    }
}
