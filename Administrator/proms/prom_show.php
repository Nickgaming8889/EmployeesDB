<?php
    require_once "../../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotion Details</title>
    <link rel="stylesheet" href="css/prom_show.css">
</head>
<body>
    <div class="go_back">
        <button><a href="prom_list.php">Back to List</a></button>
    </div>

    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM promocion WHERE id = :idPromocion");
                $stmt->bindParam(':idPromocion', $id, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $photoPath = '../photos/' . $result['foto_encryp'];

                    echo "<div class='foto'>";
                    if (!empty($result['foto_encryp']) && file_exists($photoPath)) {
                        echo "<img src='" . htmlspecialchars($photoPath) . "' alt='Promotion Image'>";
                    } else {
                        echo "<img src='../photos/default.jpg' alt='No Image Available'>";
                    }
                    echo "</div>";

                    echo "<div><strong>Name: </strong>" . htmlspecialchars($result['nombre']) . "</div>";
                    echo "<div><strong>Status: </strong>" . ($result['status'] ? "Active" : "Inactive") . "</div>";
                } else {
                    echo "<p>Promotion not found.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }
        }
    ?>
</body>
</html>
