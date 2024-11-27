<?php
    require_once "../../connectionDB.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Promotion</title>
    <link rel="stylesheet" href="css/prom_edit.css">
</head>
<body>
    <div class="go_back">
        <button><a href="prom_list.php">List Promotions</a></button>
    </div>
    <h1>Edit Promotion</h1>

    <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM promocion WHERE id = :idPromocion");
                $stmt->bindParam(':idPromocion', $id, PDO::PARAM_INT);
                $stmt->execute();

                $promotion = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($promotion) {
    ?>
                    <form id="promocion-form" action="prom_update.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($promotion['id']); ?>">

                        <div class="form-group">
                            <label for="nombre">Promotion Name:</label>
                            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($promotion['nombre']); ?>">
                        </div>

                        <div class="form-group">
                            <label for="foto">Promotion Image:</label>
                            <input type="file" id="foto" name="foto" accept="image/*">
                            <?php if (!empty($promotion['foto_encryp'])): ?>
                                <div>
                                    <img src="../photos/<?php echo htmlspecialchars($promotion['foto_encryp']); ?>" alt="Promotion Image" style="max-width: 300px;">
                                </div>
                            <?php else: ?>
                                <div>
                                    <img src="../photos/default.jpg" alt="No Image Available" style="max-width: 300px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="message" class="error-message"></div> <!-- Form-wide message -->
                        <div class="form-actions">
                            <button type="submit" class="save_btn">Update Promotion</button>
                        </div>
                    </form>
    <?php
                } else {
                    echo "<p>Promotion not found.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>No promotion ID provided.</p>";
        }
    ?>
</body>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="js/prom_edit.js"></script>
</html>
