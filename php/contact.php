<!-- <?php
// function des verfication field mail et tel

function isEmail($coco) {
    return filter_var($coco, FILTER_VALIDATE_EMAIL);
}
function isPhone($zozo) {
    return preg_match("/^[0-9 ]*$/",$zozo);
}


// https://github.com/google/recaptcha

// require ReCaptcha class 


require('../js/recaptcha-master/src/autoload.php');



// configure
$from = 'Contact mempoule cv antoni <noreply@mempoule.lol>';
$sendTo = 'AntoniSDev <antoni.salomon1337@gmail.com>';

// $sendTo = 'anto <antoni.salomon1337@gmail.com>';
$subject = 'Nouveau message du formulaire de contact - CV AntoniS';

// array variable name => Text to appear in the email
// array key => value     key : descripteur  -  value : valeur
$fields = array('firstname' => 'Firstname', 'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone', 'message' => 'Message'); 

$okMessage = 'Message envoyé, merci ! A très bientôt !';
$errorMessage = 'Erreur, merci de réessayer.';

// cle recaptcha coté server 
$recaptchaSecret = '6LfNfookAAAAAF9ywK4HqyYiQljAuTJDNoCY3FGh';

// Test pour print les données entrées dans le formulaire apres un submit
// print_r($_POST);

// let's do the sending
// Try : essaie de faire tout ce qui est dans les {} 
try
{

    if (!empty($_POST)) 
    {  // ! = if not = si le formulaire n'est pas vide

        // validate the ReCaptcha, if something is wrong, we throw an Exception, 
        // i.e. code stops executing and goes to catch() block    
        if (!isset($_POST['g-recaptcha-response'])) 
        {
            throw new \Exception('ReCaptcha is not set.');
        }

        // do not forget to enter your secret key in the config above 
        // from https://www.google.com/recaptcha/admin
        
        //useless
        //$recaptcha = new \ReCaptcha\ReCaptcha($recaptchaSecret, new \ReCaptcha\RequestMethod\CurlPost());        

		$recaptcha = new \ReCaptcha\ReCaptcha($recaptchaSecret);		

        // we validate the ReCaptcha field together with the user's IP address        

        $response = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        if (!$response->isSuccess()) 
        {
            throw new \Exception('ReCaptcha was not validated.');
        }    

        // everything went well, we can compose the message, as usually  

        
            
       

        $isValid = true;
        
        // if la fonction isEmail renvoie un truc pas vide quand on lui donne ce qui ete dans son field
        if(isEmail($_POST['email']))
        {
            echo "adresse mail valide";
        }
        else
        {
            echo "mail pas valide";
            $isValid = false;
        };

        if(isPhone($_POST['phone']))
        {
            echo $_POST['phone'];
        }
        else
        {
            echo "ceci n'est pas un numéro de téléphone valide";
            $isValid = false;
        };
        // if variable isValid true (rien = par defaut )
        if($isValid)
        {
            $emailText = "You have new message from contact form\n=============================\n";

            foreach ($_POST as $key => $value) {
                // si les $key des fields sont pas vides
                if (isset($fields[$key])) 
                {
                    // alors tu concatene  .=  la key et la value  
                    $emailText .= "$fields[$key]: $value\n";
                }
            }
    
            $headers = array('Content-Type: text/plain; charset="UTF-8";',
                'From: ' . $from,
                'Reply-To: ' . $from,
                'Return-Path: ' . $from,
            );
            // fonction mail official php
            mail($sendTo, $subject, $emailText, implode("\n", $headers));
            // osef c'est pour du ajax
            $responseArray = array('type' => 'success', 'message' => $okMessage);
        }
        else {
            echo "mail ou telephone pas valides, on envoie rien";
        };       
    }
}

// dans le cas d'une erreur tu fais ça
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    $encoded = json_encode($responseArray);
    header('Content-Type: application/json');
    echo $encoded;
}

else 
{
    echo $responseArray['message'];
}
?> -->