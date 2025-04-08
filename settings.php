<?php
require_once "session.php";
require_once "./db/database.php";
require_once "utils/helpers.php";

if(!isLoggedIn()) {
    redirect("login.php");
}


$currentUser = $_SESSION["username"];

$stmt = $pdo->prepare("SELECT id, username, email, age, phone, gender FROM users WHERE username = :username");
$stmt->execute(['username' => $currentUser]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["editUser"])) {
        $userId = $_POST["userId"];
        $newUsername = $_POST["username"];
        $newEmail = $_POST["email"];

        if (editUser($pdo, $userId, $newUsername, $newEmail)) {
            redirect("logout.php");
        }
    }
}





include "./components/header.php";
?>

    <div style="text-align:center; margin-top:60px; display:flex; flex-direction: column; gap:100px; ">

        <h1 style="text-align:center; margin-top:60px;"><?php echo $_SESSION["username"]; ?> Update your account here</h1>

        <div class="tableContainer">
            <table class="user-table">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Update Account</th>
                </tr>
                </thead>

                <tbody>
                <?php if (!empty($users) && count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user["username"]); ?></td>
                            <td><?php echo htmlspecialchars($user["email"]); ?></td>
                            <td><?php echo htmlspecialchars($user["age"]); ?></td>
                            <td><?php echo htmlspecialchars($user["phone"]); ?></td>
                            <td><?php echo htmlspecialchars($user["gender"]); ?></td>
                            <td>
                                <span>Once you updated your Credentials you will be logged out  </span>
                                <form method="POST" style="display:inline-block;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="userId" value="<?php echo htmlspecialchars($user["id"]); ?>">
                                    <input type="text" name="username" value="<?php echo htmlspecialchars($user["username"]); ?>" required>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>" required>
                                    <button class="edit" type="submit" name="editUser">Edit</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No users found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>

        </div>

    </div>


<?php include "./components/footer.php"; ?>