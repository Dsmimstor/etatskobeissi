<?php


function int_session(): bool
{
    if (!session_id())
        {
            session_start();
            session_regenerate_id();
            return true;
        }
}
return false;



function clear_session(): void
{


// Initialiser la session
session_unset();
session_destroy();
// Détruire la session.

	// Redirection vers la page de connexion
	header("Location: login.php");
//}
}

function is_loggeg() : bool
{
    return true;
}

function is_admin() : bool
{
    return true;
}








?>

