<?php
try{

    // DÃ©claration des paramÃ¨tres de connexion
    $host = "localhost:3306";

    $user = "admin";

    $bdd = "wpcem";

    $passwd  = "@Amal@JOB@@@20/*14";

    // Connexion au serveur
    $cnx = mysql_connect($host, $user,$passwd) or die("erreur de connexion au serveur");
    // mysql_set_charset('utf8',$cnx);
    mysql_select_db($bdd,$cnx) or die("erreur de connexion a la base de donnees");

    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_value='Fès Pré-Enregistrement' and `form_name`='Inscription sur place'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $fesPvs=$row[0];


    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_value='Tanger Inscription sur place' and `form_name`='Inscription sur place'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $TangerPvS=$row[0];


    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and `form_name`='Formulaire inscription pré-enregistré';";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $agadirPv=$row[0];




    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in (select `submit_time` from `wp_cf7dbplugin_submits` where `form_name`='Formulaire inscription pré-enregistré' and `field_value`='Agadir')";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $agadirP=$row[0];


    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in  (select `submit_time` from `wp_cf7dbplugin_submits` where `form_name`='Formulaire inscription pré-enregistré' and `field_value` = 'Marrakech')";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $MarakP=$row[0];


    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in  (select `submit_time` from `wp_cf7dbplugin_submits` where `form_name`='Formulaire inscription pré-enregistré' and `field_value` = 'Fès')";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $FesP=$row[0];

    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in  (select `submit_time` from `wp_cf7dbplugin_submits` where `form_name`='Formulaire inscription pré-enregistré' and `field_value` = 'Tanger')";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $TangP=$row[0];

    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in  (select `submit_time` from `wp_cf7dbplugin_submits` where `form_name`='Formulaire inscription pré-enregistré' and `field_value` = 'Rabat Pré-Enregistrement')";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $RabatP=$row[0];

    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in (select `submit_time` from `wp_cf7dbplugin_submits` where SUBSTRING(field_value,1,26) = 'Agadir (inscriptions du 13') and `form_name`='Formulaire inscreption'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $agadir=$row[0];


    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in (select `submit_time` from `wp_cf7dbplugin_submits` where SUBSTRING(field_value,1,26) = 'Marrakech (inscriptions du') and `form_name`='Formulaire inscreption'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Marak=$row[0];

    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in (select `submit_time` from `wp_cf7dbplugin_submits` where SUBSTRING(field_value,3,35) = 's (inscriptions du 14 au 27 mars)') and `form_name`='Formulaire inscreption'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Fes=$row[0];

    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in (select `submit_time` from `wp_cf7dbplugin_submits` where field_value = 'Tanger (inscriptions du 28 mars au 10 avril)') and `form_name`='Formulaire inscreption'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Tang=$row[0];

    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in (select `submit_time` from `wp_cf7dbplugin_submits` where field_value = 'Rabat (inscriptions du 17 au 30 avril)') and `form_name`='Formulaire inscreption'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Rabat=$row[0];

    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in (select `submit_time` from `wp_cf7dbplugin_submits` where field_value = 'Rabat (inscriptions du 17 au 30 avril)') and `form_name`='Formulaire inscreption'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Raba=0;

    $sqlQuery = "SELECT count(distinct(`field_value`)) FROM `wp_cf7dbplugin_submits` where `field_value` like '%@%' and `submit_time` in (select `submit_time` from `wp_cf7dbplugin_submits` where field_value = 'Casablanca (inscriptions du 8 au 22 mai)') and `form_name`='Formulaire inscreption'";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $casa=0;



    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and submit_time in (select submit_time from wp_cf7dbplugin_submits where field_value = 'Casablanca (inscriptions du 8 au 22 mai)');";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $casav=$row[0];


    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and submit_time in (select submit_time from wp_cf7dbplugin_submits where field_value = 'Rabat (inscriptions du 17 au 30 avril)');";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Rabav=$row[0];


    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and submit_time in (select submit_time from wp_cf7dbplugin_submits where field_value = 'Tanger (inscriptions du 28 mars au 10 avril)');";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Tangv=$row[0];


    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and submit_time in (select submit_time from wp_cf7dbplugin_submits where field_value = 'Fès (inscriptions du 14 au 27 mars)' and form_name = 'Formulaire inscreption');";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Fesv=$row[0];

    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and submit_time in (select submit_time from wp_cf7dbplugin_submits where field_value = 'Fès Pré-Enregistrement' and form_name = 'Formulaire inscription pré-enregistré');";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $FesPv=$row[0];

    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and submit_time in (select submit_time from wp_cf7dbplugin_submits where field_value = 'Tanger Pré-Enregistrement' and form_name = 'Formulaire inscription pré-enregistré');";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $TangPv=$row[0];


    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and submit_time in (select submit_time from wp_cf7dbplugin_submits where SUBSTRING(field_value,1,26) = 'Marrakech (inscriptions du');";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $Marakv=$row[0];


    $sqlQuery = "SELECT count(*) FROM wp_cf7dbplugin_submits where field_name='valider' and field_value='1' and submit_time in (select submit_time from wp_cf7dbplugin_submits where SUBSTRING(field_value,1,26) = 'Agadir (inscriptions du 13');";
    // $result   = mysql_query($sqlQuery);
    // $row      = mysql_fetch_array($result) ;
    // $agadirv=$row[0];









/*****************************************************
******   afficher les statistique de Rabat  **********
*****************************************************/

    $sqlQuery = "SELECT count(*) as 'count',Salon FROM wpcem.wp_invitation where valider = '1' group by Salon;";
    $result   = mysql_query($sqlQuery);
    //$row      = mysql_fetch_array($result) ;
    $RabaVins = 0;
    $RabaVpre = 0;
    $RabaVvip = 0;
    $RabaVsp  = 0;  

    while ($row = mysql_fetch_array($result)) {
        
        switch ($row['Salon']) {
        case 'Rabat (inscriptions du 17 au 30 avril)':
            $RabaVins = htmlspecialchars($row['count']);
            break;
        case 'Rabat Pré-Enregistrement':
            $RabaVpre = htmlspecialchars($row['count']);
            break;
        case 'Rabat Invitation V.I.P':
            $RabaVvip = htmlspecialchars($row['count']);
            break;
        case 'Rabat inscription sur place':
            $RabaVsp =  htmlspecialchars($row['count']);
            break;
    }
}
    //if(empty($row)){return array();	}
    //else{	return $row;	}
}catch(Exception $e){
    //var_dump($e);
    return array();
}



try{

    // DÃ©claration des paramÃ¨tres de connexion
    $host = "localhost:3306";

    $user = "admin";

    $bdd = "wpcem";

    $passwd  = "@Amal@JOB@@@20/*14";

    // Connexion au serveur
    $cnx = mysql_connect($host, $user,$passwd) or die("erreur de connexion au serveur");
    // mysql_set_charset('utf8',$cnx);
    mysql_select_db($bdd,$cnx) or die("erreur de connexion a la base de donnees");
    //if(empty($row)){return array();   }
    //else{ return $row;    }



/*******************************************************************
******   afficher les statistique des inscriptions Casablanca  *****
*******************************************************************/
    $sqlQuery0 = "SELECT count(*) as 'count',Salon FROM wpcem.wp_invitation group by Salon;";
    $result0   = mysql_query($sqlQuery0);
    $inscRabains = 0;
    $inscRabapre = 0;
    $inscRabavip = 0;
    $inscRabasp  = 0;
    $inscCasains = 0;
    $inscCasapre = 0;
    $inscCasavip = 0;
    $inscCasasp  = 0;  
    while ($row = mysql_fetch_array($result0)) {
        
        switch ($row['Salon']) {
            
            case 'CasaBlanca (inscriptions du 28 au 30 avril)':
                $inscCasains = htmlspecialchars($row['count']); // => inscription gratuite casablanca
                break;
            case 'CasaBlanca (Pre inscriptions du 28 au 30 avril)':
                $inscCasapre = htmlspecialchars($row['count']);
                break;
            case 'CasaBlanca Invitation V.I.P':
                $inscCasavip = htmlspecialchars($row['count']);
                break;
            case 'Casablanca inscription sur place 2015':
                $inscCasasp =  htmlspecialchars($row['count']);
                break;
        }
    }

/***************************************************************************
******   afficher les statistique des inscriptions validés Casablanca  *****
***************************************************************************/
    $sqlQuery0 = "SELECT count(*) as 'count',Salon FROM wpcem.wp_invitation where valider = '1' group by Salon;";
    $result0   = mysql_query($sqlQuery0);
    $inscRabaVins = 0;
    $inscRabaVpre = 0;
    $inscRabaVvip = 0;
    $inscRabaVsp  = 0;
    $inscCasaVins = 0;
    $inscCasaVpre = 0;
    $inscCasaVvip = 0;
    $inscCasaVsp  = 0;  
    while ($row = mysql_fetch_array($result0)) {
        
        switch ($row['Salon']) {
            
            case 'CasaBlanca (inscriptions du 28 au 30 avril)':
                $inscCasaVins = htmlspecialchars($row['count']); // => inscription gratuite casablanca
                break;
            case 'CasaBlanca (Pre inscriptions du 28 au 30 avril)':
                $inscCasaVpre = htmlspecialchars($row['count']);
                break;
            case 'CasaBlanca Invitation V.I.P':
                $inscCasaVvip = htmlspecialchars($row['count']);
                break;
            case 'Casablanca inscription sur place 2015':
                $inscCasaVsp =  htmlspecialchars($row['count']);
                break;
        }
    }




}catch(Exception $e){
    echo 'Caught exception: '.$e->getMessage();
    // return array();
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Statistic</title>

    <style>

        table {
            border: medium solid #000000;
            width: 50%;
        }
        td, th {
            border: thin solid #6495ed;
            width: 50%;
        }

    </style>
</head>

<body>
<h1>Statistiques</h1>
<div class="stats_container span9" style="max-width:960px; width:100%; margin:auto;">
    <div class="table-responsive">
        <table class="table">
            <tr>
                <th></th>
                <th colspan="6">2015</th>
                <th colspan="2">2014</th>
                <th colspan="2">2013</th>
            </tr>
            <tr>
                <th></th>
                <th>inscrit</th>
                <th>Entrer</th>
                <th>pr&eacute;-enregistr&eacute;</th>
                <th>pr&eacute;-enregistr&eacute; Entrer</th>
                <th>Inscrit sur place</th>
                <th>Total Entr&eacute;s</th>
                <th>inscrit</th>
                <th>Entrer</th>
                <th>inscrit</th>
                <th>Entrer</th>
            </tr>
            <tr>
                <th>Agadir</th>
                <td>1137</td>
                <td>453</td>
                <td>166</td>
                <td>40</td>
                <td>101</td>
                <td><strong>592</strong></td>
                <td>1399</td>
                <td>709</td>
                <td>3371</td>
                <td>0</td>
            </tr>
            <tr>
                <th>Marrakech</th>
                <td>1329</td>
                <td>419</td>
                <td>247</td>
                <td>92</td>
                <td>227</td>
                <td><strong>738</strong></td>
                <td>2580</td>
                <td>1032</td>
                <td>3025</td>
                <td>0</td>
            </tr>
            <tr>
                <th>F&eacute;s</th>
                <td>944</td>
                <td>336</td>
                <td>204</td>
                <td>32</td>
                <td>134</td>
                <td><strong>502</strong></td>
                <td>1492</td>
                <td>553</td>
                <td>2217</td>
                <td>0</td>
            </tr>
            <tr>
                <th>Tanger</th>
                <td>922</td>
                <td>310</td>
                <td>178</td>
                <td>30</td>
                <td>338</td>
                <td>678</td>
                <td>2837</td>
                <td>1719</td>
                <td>1967</td>
                <td>0</td>
            </tr>
            <tr>
                <th>Rabat</th>
                <td>1845</td>
                <td><?= $RabaVins ?></td>
                <td>96</td>
                <td><?= $RabaVpre ?></td>
                <td><?= $RabaVsp ?></td>
                <td><?= $RabaVsp+$RabaVpre+$RabaVins ?></td>
                <td>3832</td>
                <td>1472</td>
                <td>2707</td>
                <td>0</td>
            </tr>
            <tr>
                <th>Casablanca</th>
                <td>3748</td>

                <td><?= $inscCasaVins ?></td>
                <td><?= $inscCasapre ?></td>
                <td><?= $inscCasaVpre ?></td>
                <td><?= $inscCasasp ?></td>
                <td><?= $inscCasaVins+$inscCasaVpre+$inscCasasp ?></td>
                <td>6229</td>
                <td>3143</td>
                <td>3172</td>
                <td>0</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
        