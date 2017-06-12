<?php

require 'vendor/autoload.php';

use Symfony\Component\Ldap\LdapClient;

$host = "srv00";
$port = "";
$version = "";
$useSsl = false;
$userStartTls = false;

$dn = "anadmin";
$password = "mypassword";

// Active Directory DN
$ldap_dn = "OU=Users,DC=zakor,DC=ad";

//$ldap = new Ldap($host);


$ldap = new LdapClient($host);
$ldap->bind($dn,$password);


// query to get group =>
$group = "Utilisa. du domaine";
$query = "(&(objectCategory=group)(name=$group))";



//$query .= "(&(objectClass=user)(objectCategory=person))";
//$query = "(&(objectCategory=group)(name=Utilisa. du domaine))";

//$query = "(&(objectCategory=person)(objectClass=user)(!name=cyril))";
//$query = "(&(objectCategory=person)(objectClass=user)(cn=Utilisa. du domaine,ou=Groups,dc=zakor,dc=ad))";
//CN=Utilisa. du domaine,CN=Users,DC=zakor,DC=ad

//(&(objectCategory=user)(memberOf=cn=MyCustomGroup,ou=ouOfGroup,dc=subdomain,dc=domain,dc=com))
//"CN=Utilisa. du domaine,CN=Users,DC=zakor,DC=ad"
//(&(objectCategory=person)(objectClass=user)(!name=cyril))

/*
$group = 'Utilisa. du domaine';
// Filter by memberOf, if group is set
if(is_array($group)) {
	// Looking for a members amongst multiple groups
	if($inclusive) {
		// Inclusive - get users that are in any of the groups
		// Add OR operator
		$query .= "(|";
	} else {
		// Exclusive - only get users that are in all of the groups
		// Add AND operator
		$query .= "(&";
	}

	// Append each group
	foreach($group as $g) $query .= "(memberOf=CN=$g,$ldap_dn)";

	$query .= ")";
} elseif($group) {
	// Just looking for membership of one group
	$query .= "(memberOf=CN=$group,$ldap_dn)";
}

// Close query
if($group) $query .= ")"; else $query .= "";
*/
$resGrp = $ldap->find('dc=zakor,dc=ad',$query);
$cnGrp = $resGrp[0]['cn'][0];
$dnGrp = $resGrp[0]["dn"];
//var_dump($dnGrp);
//var_dump($resGrp);die();
// get ou
//"CN=Utilisa. du domaine,CN=Users,DC=zakor,DC=ad"

$query = "(&(objectCategory=user)(memberOf=cn=$dnGrp))";
$res = $ldap->find('dc=zakor,dc=ad',$query);
var_dump($res);die();
