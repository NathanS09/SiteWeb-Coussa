<?php
if(isset($_POST['submit'])) {
    $to = 'ns02730@gmail.com'; // Adresse e-mail de destination
    $subject = 'Nouveau message de contact'; // Sujet du message

    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Construction de l'en-tête du message
    $headers = "From: ns02730@gmail.com" . "\r\n";
    $headers .= "Reply-To: ns02730@gmail.com" . "\r\n";
    
    // Construction du corps du message
    $body = "Nom: $nom\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message";

    // Envoi du message
    if(mail($to, $subject, $body, $headers)) {
        echo "Message envoyé avec succès";
    } else {
        echo "Une erreur s'est produite lors de l'envoi du message.";
    }
}
?>