<?php
namespace App\Mail;

use App\Enum\Form\InputOption\InputOptionEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManualUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $bodyContent;
    public ?string $priorityLevel;
    public ?string $fromName;
    public ?string $fromEmail;

    public function __construct(string $bodyContent, ?string $priorityLevel = null, ?string $fromName = null, ?string $fromEmail = null)
    {
        $this->bodyContent = $bodyContent;
        $this->priorityLevel = $priorityLevel;
        $this->fromName = $fromName;
        $this->fromEmail = $fromEmail;
    }

    public function build(): self
    {
        $mail = $this->view('emails.manual')
            ->with(['bodyContent' => $this->bodyContent]);

        if ($this->fromEmail) {
            $mail->from($this->fromEmail, $this->fromName ?? $this->fromEmail);
        }

        if ($this->priorityLevel) {
            $mail->priority($this->priorityLevel == InputOptionEnum::HIGH ? 1 : ($this->priorityLevel == InputOptionEnum::LOW ? 5 : 3));
        }

        return $mail->subject('New Message from CleverDocs');
    }
}
