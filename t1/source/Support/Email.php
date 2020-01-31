<?php


namespace Source\Support;


use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    /** @var PHPMailer */
    private $mail;

    /** @var \stdClass */
    private $data;

    /** @var \Exception */
    private $error;

    public function __construct()
    {
        $this->data = new \stdClass();

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
        $this->mail->Password = EMAIL["paswd"];
    }

    public function add(string $subject, string $body, string $toName, $toAddress): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->toName = $toName;
        $this->data->toAddress = $toAddress;
        return $this;
    }

    public function attach(string $filePath, string $fileName): Email
    {
        $this->data->attach[$filePath] = $fileName;
        return $this;
    }

    public function send(string $fromName = EMAIL["from_name"], string $fromAddress = EMAIL["from_address"]): bool
    {
        try {


            return true;
        } catch (\Exception $e) {
            $this->error = $e;
            return false;
        }
    }
}