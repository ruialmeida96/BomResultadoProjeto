<?php
// Passos para permitir o envio de e-mails numa conta gmail
// 1. Ativar IMAP no GMAIL
// 2. Permitir https://myaccount.google.com/lesssecureapps

// Passos para ativar o envio de e-mails no php 7
// 1. Abrir [php.ini]
// 2. Descomentar ;extension=openssl (remover o ponto e vírgula)

use PHPMailer\PHPMailer\PHPMailer;
require_once('resources/libs/PHPMailer.php');
require_once('resources/libs/SMTP.php');
require_once('resources/libs/Exception.php');

//Exemplo de uso da função
//enviaMail('mail@server.com','assunto','mensagem');

/**
* Função que permite o envio de e-mails
* @param mixed $destinatario E-mail do destinatário
* @param mixed $assunto Cabeçalho (assunto) do e-mail
* @param mixed $mensagem Corpo (mensagem) do e-mail
* @return mixed TRUE se enviou com sucesso, FALSE se falhou o envio
*/
function enviaMail($destinatario, $assunto, $mensagem) {
  $mail = new PHPMailer(true);                            // Passar `true` ativa exceções
  try {
    //Configurações do servidor
    $mail->SMTPDebug = 0;                                 // [0-2] - Ativa o nivel de mensagens de depuração
    $mail->isSMTP();                                      // Definir para usar SMTP
    $mail->Host = 'smtp.gmail.com';                       // Especificar o servidor SMTP
    $mail->SMTPAuth = true;                               // Ativar autenticação SMTP
    $mail->Username = 'bomresultadoproj1718@gmail.com';      // SMTP username
    $mail->Password = 'ruialmeida';                     // SMTP password
    $mail->SMTPSecure = 'tls';                            // Ativar encriptação TLS , `ssl` também é aceitável
    $mail->Port = 587;                                    // Porta TCP de conexão
    $mail->CharSet = 'UTF-8';

    //Remetente e destinatário
    $mail->setFrom('bomresultadoproj1718@gmail.com', 'Bom Resultado');
    $mail->addAddress($destinatario);

    //Conteúdo
    $mail->isHTML(true);                                  // Enviar email em formato HTML
    $mail->Subject = $assunto;                            // Assunto
    $mail->Body    = $mensagem;                           // Mensagem
    $mail->AltBody = strip_tags($mensagem);               // Assunto sem formatação html

    $mail->send();
    return true;
  } catch (Exception $e) {
    echo 'O e-mail não pode ser enviado. Erro: ', $mail->ErrorInfo;
    return false;
  }
}
