<?php



// ejemplo de autenticación
//$ldaprdn  = 'montivoli';     // ldap rdn or dn
//$ldappass = '14MontH';  // associated password

// conexión al servidor LDAP
//$ldapconn = ldap_connect("167.28.175.35")
 //   or die("Could not connect to LDAP server.");
function login($ldaprdn, $ldappass){
	$ldapconn = ldap_connect("167.28.175.35") or die("Could not connect to LDAP server.");
	if ($ldapconn) {
    	// realizando la autenticación
    	$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
    	// verificación del enlace
    	return $ldapbind;
	}
}

?>