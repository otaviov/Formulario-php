<?php

//usando o PHPMailer para enviar mensagem para o email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



include_once './connection.php';
require './lib/vendor/autoload.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Criando formulario em php</title>

    <!-- Layout -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

    <!-- JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</head>

<body>
    <div class="container">
        <br>
        <form class="form-horizontal" name="add_msg" method="POST" action="" enctype="multipart/form-data">
            <fieldset>
                <!-- Título do formulário -->
                <legend>Furmulario com anexo em php</legend>

                <?php
                $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

                if (!empty($data['SendAddMsg'])) {

                    var_dump($data);

                    //salvando os dados no banco de dados o form
                    $query_msg = "INSERT INTO contacts_msgs (name, email, subject, content, created) VALUES (:name, :email, :subject, :content, NOW()) ";
                    $add_msg = $conn->prepare($query_msg);

                    $add_msg->bindParam(':name', $data['name'], PDO::PARAM_STR);
                    $add_msg->bindParam(':email', $data['email'], PDO::PARAM_STR);
                    $add_msg->bindParam(':subject', $data['subject'], PDO::PARAM_STR);
                    $add_msg->bindParam(':content', $data['content'], PDO::PARAM_STR);

                    $add_msg->execute();

                    if ($add_msg->rowCount()) {

                        $mail = new PHPMailer(true);
                        try {
                            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                            $mail->CharSet = 'UTF-8';
                            $mail->isSMTP();
                            $mail->Host = 'smtp.mailtrap.io';
                            $mail->SMTPAuth = true;
                            $mail->Username = '7bf2ab87cc4b3e';
                            $mail->Password = '5cda9d286a9a62';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 2525;

                            $mail->setFrom('amandavv32@gmail.com', 'Atendimento');
                            $mail->addAddress($data['email'], $data['name']);

                            $mail->isHTML(true);
                            $mail->Subject = 'Recebi sua mensagem de contato';

                            $mail->Body = "Olá, seja bem-vindo " . $data['name'] . "<br><br>fique a vontate para responder essa mensagem diretamente. <br>Sua mensagem será respondinda dentro de 24 horas. <br><br>Assunto: " . $data['subject'] . "<br>Conteúdo: " . $data['content'];

                            $mail->AltBody = "Olá, seja bem-vindo " . $data['name'] . "\n\nfique a vontate para responder essa mensagem diretamente. \nSua mensagem será respondinda dentro de 24 horas. \n\nAssunto: " . $data['subject'] . "\nConteúdo: " . $data['content'];

                            $mail->send();

                            echo "Mensagem de contato enviada com sucesso!<br>";
                        } catch (Exception $e) {
                            echo "Erro: Mensagem de contato não enviada";
                        }
                    } else {
                        echo "Erro: Mensagem de contato não enviada";
                    }
                }
                ?>

                <!-- Nome -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nome">Nome:</label>
                    <div class="col-md-4">
                        <input id="name" name="name" placeholder="Informe seu nome completo" class="form-control input-md" required="" type="text">
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nome">Email</label>
                    <div class="col-md-4">
                        <input id="name" name="email" placeholder="Informe seu melhor email" class="form-control input-md" required="" type="email">
                    </div>
                </div>

                <!-- Assunto -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="nome">Assunto da mensagem</label>
                    <div class="col-md-4">
                        <input id="subject" name="subject" placeholder="Informe o assunto da mensagem" class="form-control input-md" required="" type="text">
                    </div>
                </div>

                <!-- anexo -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="arquivo">Anexo</label>
                    <div class="col-md-4">
                        <input id="arquivo" name="arquivo" class="input-file" type="file">
                        <span class="help-block">2MB por mensagem</span>
                    </div>
                </div>

                <!-- Mensagem -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="mensagem">´Conteúdo da mensagem</label>
                    <div class="col-md-4">
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>
                </div>

                <!-- Botão Enviar -->
                <center>
                    <input type="submit" value="Enviar" name="SendAddMsg">
                </center>
            </fieldset>
        </form>

    </div>
</body>

</html>

