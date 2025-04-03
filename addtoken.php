<?php
include('db_config.php');

if (isset($_POST['create'])) {
    $token_bot = $_POST['token_bot'];
    $token_group = $_POST['token_group'];
    $name = $_POST['name'];
    $sql = "INSERT INTO token (token_bot, token_group, name) VALUES ('$token_bot', '$token_group', '$name')";
    $conn->query($sql);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $token_bot = $_POST['token_bot'];
    $token_group = $_POST['token_group'];
    $name = $_POST['name'];
    $sql = "UPDATE token SET token_bot='$token_bot', token_group='$token_group', name='$name' WHERE token_id=$id";
    $conn->query($sql);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM token WHERE token_id=$id";
    $conn->query($sql);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP</title>
</head>
<body>
    <form method="post">
        <input type="text" name="token_bot" placeholder="Enter token bot" required>
        <input type="text" name="token_group" placeholder="Enter token group" required>
        <input type="text" name="name" placeholder="Enter name" required>
        <button type="submit" name="create">Create</button>
    </form>
    <?php
    #include("testtoken.php");
    ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Token Bot</th>
            <th>Token Group</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM token");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['token_id']}</td>
                    <td>{$row['token_bot']}</td>
                    <td>{$row['token_group']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['action']}</td>
                    <td>
                        <a href='?delete={$row['token_id']}'>Delete</a>
                        <form method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['token_id']}'>
                            <input type='text' name='token_bot' value='{$row['token_bot']}'>
                            <input type='text' name='token_group' value='{$row['token_group']}'>
                            <input type='text' name='name' value='{$row['name']}'>
                            <input type='text' name='name' value='{$row['action']}'>
                            <button type='submit' name='update'>Update</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
<?php $conn->close(); ?>
