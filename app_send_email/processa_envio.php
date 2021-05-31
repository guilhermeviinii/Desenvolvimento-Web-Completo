<?php


// Import PHPMailer
require './lib/PHPMailer/Exception.php';
require './lib/PHPMailer/OAuth.php';
require './lib/PHPMailer/PHPMailer.php';
require './lib/PHPMailer/POP3.php';
require './lib/PHPMailer/SMTP.php';

// Namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Class de envio de email
class Message
{
    private $to = null;
    private $subject = null;
    private $message = null;
    public $status = array(
        'cod_status' => null,
        'description' => null
    );

    public function __get($atributo)
    {
        return $this->$atributo;
    }
    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }
    public function mensagemValida()
    {
        if (empty($this->to) || empty($this->subject) || empty($this->message)) {
            return false;
        }
        return true;
    }
}

$message = new Message();

$message->__set('to', $_POST['para']);
$message->__set('subject', $_POST['assunto']);
$message->__set('message', $_POST['mensagem']);


if (!$message->mensagemValida()) {
    echo 'Mensagem inválida';
    header('Location: index.php');
}

$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'guilhermeviiniii@gmail.com';                     //SMTP username
    $mail->Password   = '236658ca';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('guilhermeviiniii@gmail.com', 'Web Envio de Email');
    $mail->addAddress($message->__get('to'));     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $message->__get('subject');
    $mail->Body    = $message->__get('message');
    $mail->AltBody = 'É necessario um client que suporta HTMl para a visualização do conteudo desse email';

    $mail->send();

    $message->status['cod_status'] = 1;
    $message->status['description'] = 'Email enviado com sucesso';
} catch (Exception $e) {
    $message->status['cod_status'] = 2;
    $message->status['description'] = 'Não foi possível enviar esse email, Por favor tente mais tarde' . $mail->ErrorInfo;
    echo '<pre>';
    print_r($message->status['description']);
    echo '</pre>';
}

?>

<html>

<head>
    <meta charset="utf-8" />
    <title>App Mail Send</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <div class="container">

        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
            <h2>Send Mail</h2>
            <p class="lead">Seu app de envio de e-mails particular!</p>
        </div>

        <div class="row">
            <div class="col-md-12">

                <?php if ($message->status['cod_status'] == 1) { ?>
                    <div class="container">
                        <h1 class="display-4 text-success">Sucesso</h1>
                        <p><?= $message->status['description'] ?></p>
                        <a href="index.php " class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                    </div>
                <?php } ?>
                <?php if ($message->status['cod_status'] == 2) { ?>
                    <div class="container">
                        <h1 class="display-4 text-danger">Ops!</h1>
                        <p><?= $message->status['description'] ?></p>
                        <a href="index.php " class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>

</body>

</html>