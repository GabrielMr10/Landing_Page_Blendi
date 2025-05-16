<?php
// Configurações de cabeçalho
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Ativa exibição de erros (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log para verificar se o arquivo está sendo acessado
file_put_contents('debug.log', 'Arquivo acessado em: ' . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

// Log do método da requisição
file_put_contents('debug.log', 'Método: ' . $_SERVER['REQUEST_METHOD'] . "\n", FILE_APPEND);

// Log dos dados recebidos
file_put_contents('debug.log', 'POST: ' . print_r($_POST, true) . "\n", FILE_APPEND);

// Verifica o método da requisição
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Método não permitido. Use POST.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificação dos captchas (agora opcional)
    $captcha1 = isset($_POST['captcha1']) ? "Sim" : "Não";
    $captcha2 = isset($_POST['captcha2']) ? "Sim" : "Não";
    $captcha3 = isset($_POST['captcha3']) ? "Sim" : "Não";
    $captcha4 = isset($_POST['captcha4']) ? "Sim" : "Não";

    // Configurações do email
    $config = [
        'from_email' => 'contato@saiadoaluguell.com.br',
        'from_name' => 'Saia do Aluguel',
        'reply_to' => 'contato@saiadoaluguell.com.br'
    ];

    // Headers aprimorados
    $headers  = "From: {$config['from_name']} <{$config['from_email']}>\r\n";
    $headers .= "Reply-To: {$config['reply_to']}\r\n";
    $headers .= "Return-Path: {$config['from_email']}\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "X-Priority: 1\r\n";
    $headers .= "Message-ID: <" . time() . rand(1000,9999) . "@{$_SERVER['SERVER_NAME']}>\r\n";
    $headers .= "Date: " . date("r") . "\r\n";

    // Dados do formulário
    $nome = filter_input(INPUT_POST, 'Nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'Email', FILTER_SANITIZE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'Telefone', FILTER_SANITIZE_STRING);
    $renda_mensal = filter_input(INPUT_POST, 'Renda_Mensal', FILTER_SANITIZE_STRING);
    $valor_entrada = filter_input(INPUT_POST, 'Valor_Entrada', FILTER_SANITIZE_STRING);

    // Mensagem para você
    $para = "saiadoaluguell12@gmail.com";
    $assunto = "Novo Contato do Formulário";
    
    $mensagem = "<html><body>";
    $mensagem .= "<h2>Novo Contato do Formulário</h2>";
    $mensagem .= "<p><strong>Nome:</strong> " . $nome . "</p>";
    $mensagem .= "<p><strong>Email:</strong> " . $email . "</p>";
    $mensagem .= "<p><strong>Telefone:</strong> " . $telefone . "</p>";
    $mensagem .= "<p><strong>Renda Mensal:</strong> " . $renda_mensal . "</p>";
    $mensagem .= "<p><strong>Possui alguma restrição no nome?:</strong> " . $valor_entrada . "</p>";
    $mensagem .= "<p><strong>Verificações:</strong></p>";
    $mensagem .= "<p>- Possui 3 anos de trabalho sob regime do FGTS: " . $captcha1 . "</p>";
    $mensagem .= "<p>- Já foi beneficiado com subsídio FGTS: " . $captcha2 . "</p>";
    $mensagem .= "<p>- Mais de um comprador ou dependente: " . $captcha3 . "</p>";
    $mensagem .= "<p>- Tem conta corrente na Caixa: " . $captcha4 . "</p>";
    $mensagem .= "</body></html>";

    try {
        // Envio do email principal
        $enviado = mail($para, $assunto, $mensagem, $headers);

        if ($enviado) {
            // Email de confirmação para o cliente
            $mensagem_cliente = '
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recebemos sua mensagem! - Equipe Saia do Aluguell</title>
    <style>
        @media only screen and (max-width: 620px) {
            table[class=body] {
                width: 100% !important;
            }
            table[class=body] td {
                padding: 20px !important;
            }
            table[class=body] .main-table {
                width: 100% !important;
            }
            table[class=body] .logo img {
                max-width: 150px !important;
            }
            table[class=body] h1 {
                font-size: 20px !important;
            }
            table[class=body] p {
                font-size: 14px !important;
            }
            table[class=body] .social-links img {
                width: 30px !important;
                height: 30px !important;
            }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table class="body" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table class="main-table" width="600" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 100%;">
                    <!-- Cabeçalho -->
                    <tr>
                        <td class="logo" align="center" bgcolor="#1c1c1c" style="padding: 30px; border-radius: 10px 10px 0 0; border-bottom: 3px solid #5eead4;">
                            <img src="https://saiadoaluguell.com.br/img/33333.png" alt="Logo" style="max-width: 200px; width: 100%; height: auto;">
                        </td>
                    </tr>

                    <!-- Conteúdo -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 30px;">
                                        <img src="https://saiadoaluguell.com.br/img/verificar.png" alt="Sucesso" style="width: 80px; max-width: 100%; height: auto;">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-bottom: 30px;">
                                        <h1 style="color: #1c1c1c; margin: 0; font-size: 24px; line-height: 1.3;">Olá, ' . $nome . '!</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #363636; font-size: 16px; line-height: 1.6; padding-bottom: 30px;">
                                        <p style="margin: 0 0 15px 0;">Recebemos sua mensagem com sucesso e agradecemos pelo seu interesse!</p>
                                        <p style="margin: 0;">Nossa equipe está analisando suas informações e entraremos em contato em breve para dar continuidade ao seu atendimento.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px; background-color: #f8f8f8; border-radius: 10px;">
                                        <h2 style="color: #1c1c1c; font-size: 18px; margin: 0 0 15px 0;">Próximos Passos:</h2>
                                        <ul style="color: #363636; padding-left: 20px; margin: 0; line-height: 1.6;">
                                            <li style="margin-bottom: 10px;">Nossa equipe analisará suas informações com atenção</li>
                                            <li style="margin-bottom: 10px;">Entraremos em contato em até 24 horas úteis</li>
                                            <li style="margin-bottom: 10px;">Prepare seus documentos básicos para agilizar o processo</li>
                                            <li style="margin-bottom: 10px;">Fique atento ao seu WhatsApp e email</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 30px;">
                                        <a href="https://api.whatsapp.com/send?phone=554333043476&text=Ol%C3%A1,%20equipe%20Saia%20do%20Aluguell!%20Eu%20tenho%20interesse%20em%20comprar%20um%20im%C3%B3vel!" style="display: inline-block; background-color: #25d366; color: white; padding: 12px 30px; text-decoration: none; border-radius: 25px; font-weight: bold;">Falar no WhatsApp</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Rodapé -->
                    <tr>
                        <td bgcolor="#1c1c1c" style="padding: 30px; border-radius: 0 0 10px 10px; color: white; text-align: center;">
                            <p style="margin: 0 0 15px 0; font-size: 14px;">Siga-nos nas redes sociais:</p>
                            <div class="social-links" style="margin-bottom: 20px;">
                                <a href="https://www.facebook.com/share/1G14Csgt1W/" style="margin: 0 10px; text-decoration: none;">
                                    <img src="https://saiadoaluguell.com.br/img/facebook.png" alt="Facebook" width="35" height="35" style="border: 0;">
                                </a>
                                <a href="https://www.instagram.com/lubatchewsky.imoveis?igsh=MThncXUzNm1mbHVhOA==" style="margin: 0 10px; text-decoration: none;">
                                    <img src="https://saiadoaluguell.com.br/img/instagram.png" alt="Instagram" width="35" height="35" style="border: 0;">
                                </a>
                            </div>
                            <p style="margin: 0; font-size: 12px; color: #999999;">© 2025 Desenvolvido por Gabriel Meira. Todos os direitos reservados.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
';

            // Envio do email para o cliente
            mail($email, "Recebemos sua mensagem! - Equipe Saia do Aluguell", $mensagem_cliente, $headers);

            // Redireciona para página de obrigado
            header('Location: agradecimento');
            exit();
        } else {
            throw new Exception("Erro ao enviar o email");
        }
    } catch (Exception $e) {
        // Log de erro
        file_put_contents('debug.log', 'Erro: ' . $e->getMessage() . "\n", FILE_APPEND);
        echo "Erro: " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "Método não permitido";
}
?> 