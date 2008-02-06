<?php
// Define database context names
//   The concept here is that we need multiple copies of the entire IP
//   database to support different "contexts".  For example - the current
//   database scheme doesn't allow a single server to have both an
//   internal and external DNS name .. or an IP address in two different
//   MPLS networks.  By having multiple IP Database instances we can leave
//   all the code the same and simply switch the "context", or database,
//   we are using.
//
//   I use this array as a place to store the MySQL database info as well,
//   to keep all database connection info in one place.
//
//   Note: after adding a new context here you also need to add the details
//         for that new context in functions_db.php as well.
//   Note: the context used is determined by the value of $conf['mysql_context']
//         at the time functions_db.php is included.
//   Note: Available ADODB types:
//         mysql, mysqlt, oracle, oci8, mssql, postgres, sybase, vfp, access, ibase and many others.
$db_context = array (

    // Note:  I set the login up as ona-sys so that we could have
    // a more "functional" user to do connections with that is not root or
    // some sort of full admin.
    //
    // Type:
    'mysqlt' => array(
        // Name:
        'default' => array(
            'description' => 'Website metadata',
            'primary' => array(
                'db_type'     => 'mysqlt',  // using mysqlt for transaction support
                'db_host'     => 'localhost',
                'db_login'    => 'ona_sys',
                'db_passwd'   => '',
                'db_database' => 'ona',
                'db_debug'    => false,
            ),
            // You can use this to connect to a secondary server that is
            // syncronized on the back end.
            'secondary' => array(
                'db_type'     => 'mysqlt',
                'db_host'     => 'localhost',
                'db_login'    => 'ona_sys',
                'db_passwd'   => '',
                'db_database' => 'ona',
                'db_debug'    => false,
            ),
        ),
    ),
);
?>