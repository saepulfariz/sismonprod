<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail  = '';
    public string $fromName   = '';
    public string $recipients = '';

    /**
     * The "user agent"
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * The mail sending protocol: mail, sendmail, smtp
     */
    public string $protocol = 'mail';

    /**
     * The server path to Sendmail.
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * SMTP Server Address
     */
    public string $SMTPHost = '';

    /**
     * SMTP Username
     */
    public string $SMTPUser = '';

    /**
     * SMTP Password
     */
    public string $SMTPPass = '';

    /**
     * SMTP Port
     */
    public int $SMTPPort = 25;

    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 5;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption.
     *
     * @var string '', 'tls' or 'ssl'. 'tls' will issue a STARTTLS command
     *             to the server. 'ssl' means implicit SSL. Connection on port
     *             465 should set this to ''.
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;

    /**
     * Type of mail, either 'text' or 'html'
     */
    public string $mailType = 'text';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8';

    /**
     * Whether to validate the email address
     */
    public bool $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public int $priority = 3;

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     */
    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     */
    public bool $DSN = false;

    function __construct()
    {
        parent::__construct();
        // $this->fromEmail = EMAIL_FROM;
        // $this->fromName = EMAIL_FROM_NAME;
        // $this->recipients = EMAIL_RECIPIENTS;
        // $this->protocol = EMAIL_PROTOCOL;
        // $this->SMTPHost = EMAIL_HOST;
        // $this->SMTPUser = EMAIL_USERNAME;
        // $this->SMTPPass = EMAIL_PASSWORD;
        // $this->SMTPPort = EMAIL_PORT;
        // $this->SMTPCrypto = EMAIL_SMTP_SECURE;
        // $this->mailType = EMAIL_MAIL_TYPE;

        $this->fromEmail = $_SERVER['EMAIL_FROM'];
        $this->fromName = $_SERVER['EMAIL_FROM_NAME'];
        $this->recipients = $_SERVER['EMAIL_RECIPIENTS'];
        $this->protocol = $_SERVER['EMAIL_PROTOCOL'];
        $this->SMTPHost = $_SERVER['EMAIL_HOST'];
        $this->SMTPUser = $_SERVER['EMAIL_USERNAME'];
        $this->SMTPPass = $_SERVER['EMAIL_PASSWORD'];
        $this->SMTPPort = $_SERVER['EMAIL_PORT'];
        $this->SMTPCrypto = $_SERVER['EMAIL_SMTP_SECURE'];
        $this->mailType = $_SERVER['EMAIL_MAIL_TYPE'];
    }
}
