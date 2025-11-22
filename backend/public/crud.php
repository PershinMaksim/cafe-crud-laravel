<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>CRUD Operations</h1>
        
        <div class="tabs">
            <button class="tab-button active" onclick="openTab('create')">Create</button>
            <button class="tab-button" onclick="openTab('read')">Read</button>
            <button class="tab-button" onclick="openTab('update')">Update</button>
            <button class="tab-button" onclick="openTab('delete')">Delete</button>
        </div>

        <!-- Create Tab -->
        <div id="create" class="tab-content active">
            <h2>Create Dish</h2>
            <form method="POST" action="create.php">
                <input type="text" name="name" placeholder="Name" required>
                <textarea name="description" placeholder="Description" rows="4"></textarea>
                <input type="number" name="price" step="0.01" placeholder="Price" required>
                <input type="number" name="quantity" placeholder="Quantity" required>
                <label>
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"> Active
                </label>
                <button type="submit">Create Dish</button>
            </form>
            <?php if (isset($_GET['create_result'])): 
                $result = json_decode(urldecode($_GET['create_result']), true);
            ?>
                <div class="result <?php echo $_GET['create_success'] ? 'success' : 'error'; ?>">
                    <strong>Status:</strong> <?php echo $result['success'] ? 'Success' : 'Error'; ?><br>
                    <strong>Message:</strong> <?php echo htmlspecialchars($result['message']); ?><br>
                    <?php if (isset($result['data'])): ?>
                        <strong>Data:</strong><br>
                        <pre><?php echo htmlspecialchars(json_encode($result['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Read Tab -->
        <div id="read" class="tab-content">
            <h2>Read Dish</h2>
            <form method="POST" action="read.php">
                <input type="number" name="id" placeholder="Enter ID" required>
                <button type="submit">Get Dish</button>
            </form>
            <?php if (isset($_GET['read_result'])): 
                $result = json_decode(urldecode($_GET['read_result']), true);
            ?>
                <div class="result <?php echo $_GET['read_success'] ? 'success' : 'error'; ?>">
                    <strong>Status:</strong> <?php echo $result['success'] ? 'Success' : 'Error'; ?><br>
                    <strong>Message:</strong> <?php echo htmlspecialchars($result['message']); ?><br>
                    <?php if (isset($result['data'])): ?>
                        <strong>Data:</strong><br>
                        <pre><?php echo htmlspecialchars(json_encode($result['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Update Tab -->
        <div id="update" class="tab-content">
            <h2>Update Dish</h2>
            
            <!-- Форма для загрузки данных -->
            <form method="POST" action="load_dish.php">
                <input type="number" name="id" placeholder="Enter ID to load" required>
                <button type="submit">Load Dish Data</button>
            </form>

            <!-- Форма для обновления (появляется после загрузки) -->
            <?php if (isset($_GET['dish_data'])): 
                $dishData = json_decode(urldecode($_GET['dish_data']), true);
                if ($dishData && isset($dishData['data'])): 
                    $dish = $dishData['data'];
            ?>
                <h3>Edit Dish:</h3>
                <form method="POST" action="update.php">
                    <input type="hidden" name="id" value="<?php echo $itdishem['id']; ?>">
                    <input type="text" name="name" value="<?php echo htmlspecialchars($dish['name']); ?>" required>
                    <textarea name="description" rows="4"><?php echo htmlspecialchars($dish['description']); ?></textarea>
                    <input type="number" name="price" step="0.01" value="<?php echo $dish['price']; ?>" required>
                    <input type="number" name="quantity" value="<?php echo $dish['quantity']; ?>" required>
                    <label>
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1">
                               <?php echo $dish['is_active'] ? 'checked' : ''; ?>> Active
                    </label>
                    <button type="submit">Update Dish</button>
                </form>
            <?php endif; endif; ?>

            <?php if (isset($_GET['update_result'])): 
                $result = json_decode(urldecode($_GET['update_result']), true);
            ?>
                <div class="result <?php echo $_GET['update_success'] ? 'success' : 'error'; ?>">
                    <strong>Status:</strong> <?php echo $result['success'] ? 'Success' : 'Error'; ?><br>
                    <strong>Message:</strong> <?php echo htmlspecialchars($result['message']); ?><br>
                    <?php if (isset($result['data'])): ?>
                        <strong>Data:</strong><br>
                        <pre><?php echo htmlspecialchars(json_encode($result['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Delete Tab -->
        <div id="delete" class="tab-content">
            <h2>Delete Dish</h2>
            <form method="POST" action="delete.php" onsubmit="return confirm('Are you sure you want to delete this dish?')">
                <input type="number" name="id" placeholder="Enter ID" required>
                <button type="submit" class="danger">Delete Dish</button>
            </form>
            <?php if (isset($_GET['delete_result'])): 
                $result = json_decode(urldecode($_GET['delete_result']), true);
            ?>
                <div class="result <?php echo $_GET['delete_success'] ? 'success' : 'error'; ?>">
                    <strong>Status:</strong> <?php echo $result['success'] ? 'Success' : 'Error'; ?><br>
                    <strong>Message:</strong> <?php echo htmlspecialchars($result['message']); ?><br>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="tabs.js"></script>
    
    <script>
        // Автоматическое переключение на нужную вкладку после операций
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            if (tab) {
                openTab(tab);
            }
        });
    </script>
</body>
</html>