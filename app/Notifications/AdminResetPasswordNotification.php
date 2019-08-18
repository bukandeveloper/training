<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification {

    use Queueable;

    //Token handler
    public $token;

    /**
     * Create a new notification instance.
     *
     */
    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('パスワードのリセット要求を受け取りました')
            // ->line("この度は、パスワード変更のご依頼いただき誠にありがとうございます。下記のボタンを押してください。")
            // Use url instead of route here, if using route need to define in web.php
            ->action('パスワードをリセット', url('admin/password/reset', $this->token))
            ->line("上記のリンクが使用できない場合、次の URL をコピーしてブラウザに貼り付けてください:")
            ->line(url('admin/password/reset', $this->token))
            ->line("新しいパスワードを要求していない場合やこの通知を誤って受け取った場合、この電子メールを無視すればパスワードは変更されません。");
    }

}
