<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendNoticeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     * 创建一个新的任务实例
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     * 运行任务
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;

        Mail::send('emails.notice', ['user' => $user], function ($msg) use ($user) {
            // 发件人的邮箱和用户名
            $msg->from('code0807@163.com', 'LC');
            // 收件人的邮箱地址,用户名,提示消息
            $msg->to($user->email, $user->name);
            $msg->subject('队列发送邮件');
        });
    }
}
