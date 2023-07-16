<?php



namespace config\mailFile;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mailFile
{
    private   $ownerEmail     = "adesarashyam22112001@gmail.com";
    private   $ownerEmailPass = "shyam22112001mayhs";
    private   $ownerEmailBCC  = "shyamadesara7911@gmail.com";
    private   $filePath       = [];
    protected $mail;
    public    $status;

    public function __construct()
    {
        if (!class_exists('PHPMailer')) {
            $this->mail = new PHPMailer();
        }
    }

    /**
     * @param string $userEmail
     * @param string $subject
     * @param string $content
     * @param bool   $attachment
     * @param bool   $bcc
     *
     * @return bool|string
     * @throws Exception
     */
    private function setupMail(string $userEmail, string $subject, string $content, bool $attachment = false, bool $bcc = false)
    {
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $this->ownerEmail;
        $this->mail->Password   = $this->ownerEmailPass;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port       = 587;
        // Sender info
        $this->mail->setFrom($this->ownerEmail, 'LOOKOUT');
        // Add a recipient
        $this->mail->addAddress($userEmail);
        $this->mail->isHTML(true);
        if ($bcc) {
            $this->mail->addBCC($this->ownerEmailBCC);

        }
        if ($attachment) {
            if (is_array($this->filePath) && (count($this->filePath) > 0)) {
                foreach ($this->filePath as $file) {
                    $this->mail->addAttachment($file);
                }
            }
        }
        $this->mail->Subject = $subject;
        $this->mail->Body    = $content;
        // Send email
        if (!$this->mail->send()) {
            $this->status = '<b>Message could not be sent. Mailer Error:</b> ' . $this->mail->ErrorInfo;
            $ret = false;
        } else {
            $ret = true;
            $this->status = true;
        }
        return $ret;
    }

    /**
     * @param string $userEmail
     * @param string $subject
     * @param string $content
     *
     * @return bool|string
     * @throws Exception
     */
    public function sendMail(string $userEmail, string $subject, string $content)
    {
        $ret = $this->setupMail($userEmail, $subject, $content);
        return $ret;
    }

    /**
     * @param string $userEmail
     * @param string $subject
     * @param string $content
     * @param bool   $attachment
     * @param array  $filesPath
     * @param bool   $bcc
     *
     * @return bool|string
     * @throws Exception
     */
    public function sendMailWithAttachment(string $userEmail, string $subject, string $content, array $filesPath, bool $bcc = false, bool $attachment = false)
    {
        if ((is_array($filesPath) && count($filesPath) > 0) && $attachment) {
            foreach ($filesPath as $filePath) {
                $this->filePath [] = _UPLOAD . $filePath;
            }
            $ret = $this->setupMail($userEmail, $subject, $content, $attachment, $bcc);
        } else {
            $ret = 'Files are not correct';
        }
        return $ret;
    }

    protected function randomizeValueFunc($res = false, $len = 0)
    {
        $temp = '';
        if ($res == true) {
            for ($i = 1; $i <= $len; $i++) {
                $choice = rand(1, 2);
                switch ($choice) {
                    case 1:
                        $temp .= $this->num();
                        break;
                    case 2:
                        $temp .= $this->alpha();
                        break;
                }
            }
        }
        return $temp;
    }

    /**
     * @return string
     */
    protected function alpha(): string
    {
        $alpha = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $ret   = $alpha[array_rand($alpha)];
        return $ret;
    }

    /**
     * @return string
     */
    protected function num(): string
    {
        $num = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $num = $num[array_rand($num)];
        return $num;
    }
}
