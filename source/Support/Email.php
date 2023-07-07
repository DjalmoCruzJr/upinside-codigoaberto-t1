<?php


namespace Source\Support;


use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use stdClass;

/**
 * Class Email
 * @package Source\Support
 */
class Email
{
    /** @var PHPMailer */
    private $mail;

    /** @var stdClass */
    private $data;

    /** @var Exception */
    private $error;

    /**
     * Email constructor.
     */
    public function __construct()
    {
        $this->data = new stdClass();

        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->set("br");
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = EMAIL["protocol"];
        $this->mail->CharSet = EMAIL["charset"];
        $this->mail->Host = EMAIL["host"];
        $this->mail->Port = EMAIL["port"];
        $this->mail->Username = EMAIL["username"];
        $this->mail->Password = EMAIL["passwd"];
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $toName
     * @param $toAddress
     * @return Email
     */
    public function add(string $subject, string $body, string $toName, $toAddress): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->toName = $toName;
        $this->data->toAddress = $toAddress;
        return $this;
    }

    /**
     * @param string $filePath
     * @param string $fileName
     * @return Email
     */
    public function attach(string $filePath, string $fileName): Email
    {
        $this->data->attachments[$filePath] = $fileName;
        return $this;
    }

    /**
     * @param string $fromName
     * @param string $fromAddress
     * @return bool
     */
    public function send(string $fromName = EMAIL["from_name"], string $fromAddress = EMAIL["from_address"]): bool
    {
        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);
            $this->mail->addAddress($this->data->toAddress, $this->data->toName);
            $this->mail->setFrom($fromAddress, $fromName);

            if (!empty($this->data->attachments)) {
                foreach ($this->data->attachments as $attachmentFile => $attachmentName) {
                    $this->mail->addAttachment($attachmentFile, $attachmentName);
                }
            }

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            $this->error = $e;
            return false;
        }
    }

    /**
     * @return Exception|null
     */
    public function error(): ?Exception
    {
        return $this->error;
    }
}