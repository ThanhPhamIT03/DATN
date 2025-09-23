<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Gửi mail kèm một file (nếu có)
     * 
     * @param string $toEmail      
     * @param string $subject     
     * @param string $view
     * @param array $data 
     * @param string|null $attachment 
     * @return void
     */
    public static function sendMail(string $toEmail, string $subject, string $view, array $data = [], string $attachment = null)
    {
        if ($attachment) {
            $data['attachmentName'] = basename($attachment); 
            $data['attachmentPath'] = $attachment; 
        }

        Mail::send($view, $data, function ($message) use ($toEmail, $subject, $attachment) {
            $message->to($toEmail)
                ->subject($subject);

            // Gắn file nếu có và tồn tại
            if ($attachment && file_exists($attachment)) {
                $message->attach($attachment);
            }
        });
    }
}
