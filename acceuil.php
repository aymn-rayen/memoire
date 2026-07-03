<?php
// Database connection parameters
require_once __DIR__ . '/db_info.php';

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // SQL query to sum the values from 5 tables
    $sql = "
        SELECT 
            (SELECT DISTINCT SUM(NUM_CMDE) FROM biskra_commande) +
            (SELECT DISTINCT SUM(NUM_CMDE) FROM alger_commande) +
            (SELECT DISTINCT SUM(NUM_CMDE) FROM oran_commande) +
            (SELECT DISTINCT SUM(NUM_CMDE) FROM bechar_commande) +
            (SELECT DISTINCT SUM(NUM_CMDE) FROM annaba_commande) AS total_sum
    ";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);
    
    // Execute the query
    $stmt->execute();
    
    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
//facts
    $sql1 = "
    SELECT 
        (SELECT SUM(NUM_FACT) FROM biskra_entete_facture) +
        (SELECT SUM(NUM_FACT) FROM alger_entete_facture) +
        (SELECT SUM(NUM_FACT) FROM oran_entete_facture) +
        (SELECT SUM(NUM_FACT) FROM annaba_entete_facture) +
        (SELECT SUM(NUM_FACT) FROM bechar_entete_facture) AS total_fact
    ";
    
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);


    // Requête SQL pour récupérer les données et calculer le profit
$sql2 = "SELECT SUM(PRIX_UNIT_VENTE_HT - COUT_UNIT_ACHAT) AS profit_total FROM planche";
$result2 = $conn->query($sql2);

// Affichage du profit total
  
$sql3 = "SELECT SUM(PRIX_UNIT_VENTE_HT - COUT_UNIT_ACHAT) AS profit_total FROM planche";
$stmt3 = $conn->query($sql3);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCHdash</title>
    <link rel="shortcut icon" href="images/logopch.png" />
      <link rel="stylesheet" href="sidebar/assets/css/backend.css?v=1.0.0">
      <link rel="stylesheet" href="sidebar/assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
      <link rel="stylesheet" href="sidebar/assets/css/backend-plugin.min.css">
      <link rel="stylesheet" href="sidebar/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">
      <link rel="stylesheet" href="sidebar/assets/vendor/remixicon/fonts/remixicon.css">
</head>
<body>
<div class="wrapper">
    <?php  
    include("sidebar/sidebar.php");
    ?>
    <div class="content-page">
         <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h5>Commandes </h5>
                            <span class="badge badge-primary">par année</span>
                        </div>
                        <h3><span class="counter"> <?php echo  $result["total_sum"] . "<br>"; ?></span></h3>
                        <div class="iq-progress-bar bg-primary-light mt-2">
                            <span class="bg-primary iq-progress progress-1" data-percent="65"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h5>Factures</h5>
                            <span class="badge badge-warning">par année</span>
                        </div>
                        <h3><span class="counter"> <?php echo   $result1["total_fact"];?></span></h3>
                        <div class="iq-progress-bar bg-warning-light mt-2">
                            <span class="bg-warning iq-progress progress-1" data-percent="85"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h5>Profit</h5>
                            <span class="badge badge-success">par année</span>
                        </div>
                        <h3><span class="counter"> <?php // Affichage du profit total
                                    if ($stmt3->rowCount() > 0) {
                                    $row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
                                    echo $row3["profit_total"] . "DA";} else {
                                    echo "Aucune donnée trouvée.";}
                       ?></span></h3>
                        <div class="iq-progress-bar bg-success-light mt-2">
                            <span class="bg-success iq-progress progress-1" data-percent="45"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card card-block card-stretch card-height">
                    <div class="card-body">
                        <div class="top-block d-flex align-items-center justify-content-between">
                            <h5>Profit</h5>
                            <span class="badge badge-info">Weekly</span>
                        </div>
                        <h3>$<span class="counter">2500</span></h3>
                        <div class="iq-progress-bar bg-info-light mt-2">
                            <span class="bg-info iq-progress progress-1" data-percent="55"></span>
                        </div>
               
</div>
</div>
</div>
<div>  <?php include('charts/ventepargamme.php'); ?></div>

<div>  <?php include('charts/ventepargamme.php'); ?></div>

<!-------------------------------------------------------------------------------->
        <!-- Backend Bundle JavaScript -->
        <script src="sidebar/assets/js/backend-bundle.min.js"></script>
    
    <!-- Table Treeview JavaScript -->
    <script src="sidebar/assets/js/table-treeview.js"></script>
    
    <!-- Chart Custom JavaScript -->
    <script src="sidebar/assets/js/customizer.js"></script>
    
    <!-- Chart Custom JavaScript -->
    <script async src="sidebar/assets/js/chart-custom.js"></script>
    
    <!-- app JavaScript -->
    <script src="sidebar/assets/js/app.js"></script>
</body>
</html>
