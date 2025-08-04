<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExpenseReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->subject('Your Filtered Expense Report')
                    ->markdown('emails.expense.report')
                    ->attach($this->filePath, [
                        'as' => 'expense_report.csv',
                        'mime' => 'text/csv',
                    ]);
    }
}
