<?php if(isAdmin()): ?>
    <div class="userTable">
        <?php if(isset($_SESSION["message"])): ?>
            <div class="notification-container">
                <div class="notification <?php echo $_SESSION["msg_type"]?>">
                    <?php echo $_SESSION["message"];?>
                    <?php unset($_SESSION["message"]);?>
                </div>
            </div>
        <?php endif; ?>

        <h2>Users</h2>

        <div class="tableContainer">
            <div class="table-header">
                <p><span><?php echo !empty($this->getUsers()) ? count($this->getUsers()) : 0 ?> active users</span></p>

                <div class="search">
                    <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="text" name="search" placeholder="Search by username or email" value="<?php echo htmlspecialchars($this->getSearchTerm()); ?>">
                        <button type="submit">
                            <i class="fa-solid fa-magnifying-glass fa-xl"></i>
                        </button>
                    </form>

                    <button id="addUserBtn">
                        <i class="fa-solid fa-plus fa-xl"></i>
                    </button>
                </div>
            </div>

            <table class="user-table">
                <thead>
                <tr>
                    <th>Role</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Registration Date</th>
                    <th>Published Blogs</th>
                    <th>Update User</th>
                </tr>
                </thead>

                <tbody>
                <?php if (!empty($this->getUsers()) && count($this->getUsers()) > 0): ?>
                    <?php foreach ($this->getUsers() as $user): ?>
                        <tr>
                            <td>
                                <?php
                                if ($user["id"] === $_SESSION['user_id']) {
                                    echo "<span class='admin'>you</span>";
                                } elseif ($user["admin"]) {
                                    echo "<span class='admin'>admin</span>";
                                } else {
                                    echo "<span class='user'>user</span>";
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($user["username"]); ?></td>
                            <td><?php echo htmlspecialchars($user["email"]); ?></td>
                            <td><?php echo htmlspecialchars($user["age"]); ?></td>
                            <td><?php echo htmlspecialchars($user["phone"]); ?></td>
                            <td><?php echo htmlspecialchars($user["gender"]); ?></td>
                            <td><?php echo htmlspecialchars($user["created_at"]); ?></td>
                            <td><?php echo htmlspecialchars($user["blogs_num"]); ?></td>

                            <?php if ($user["admin"]): ?>
                                <td>
                                    <span class="restricted">Restricted!</span>
                                </td>
                            <?php else: ?>
                                <td>
                                    <div class="action-buttons" >
                                        <button class="edit-btn"
                                                type="button"
                                                data-user-id="<?php echo $user['id']; ?>"
                                                data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                                data-email="<?php echo htmlspecialchars($user['email']); ?>"
                                        >
                                            <span class="edit-text">Edit</span>
                                            <span class="edit-icon"><i class="fa-solid fa-pen fa-sm"></i></span>
                                        </button>

                                        <button class="delete-btn"
                                                type="button"
                                                data-user-id="<?php echo $user['id']; ?>">
                                            <span class="delete-icon"><i class="fa-solid fa-trash fa-sm"></i></span>
                                            <span class="delete-text">Delete</span>
                                        </button>
                                    </div>
                                </td>
                            <?php endif; ?>
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

        <!-- Register Modal -->
        <div id="registerModal" class="modal">
            <div class="form-container">
                <div class="modal-header">
                    <h4>Register New User</h4>
                    <span class="close">&times;</span>
                </div>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <!-- username-->
                    <input type="text" name="username" placeholder="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : "" ?>" required>
                    <?php if (isset($this->getErrors()['username'])): ?>
                        <span class="error"><?php echo $this->getErrors()['username'] ?></span>
                    <?php endif; ?>
                    <br>

                    <!-- email-->
                    <input type="email" name="email" placeholder="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : "" ?>" required>
                    <?php if (isset($this->getErrors()['email'])): ?>
                        <span class="error"><?php echo $this->getErrors()['email'] ?></span>
                    <?php endif; ?>
                    <br>

                    <!-- password-->
                    <input type="password" name="password" placeholder="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : "" ?>" required>
                    <?php if (isset($this->getErrors()['password'])): ?>
                        <span class="error"><?php echo $this->getErrors()['password'] ?></span>
                    <?php endif; ?>
                    <br>

                    <input type="password" name="confPassword" placeholder="confirm password" required>
                    <?php if (isset($this->getErrors()['confPassword'])): ?>
                        <span class="error"><?php echo $this->getErrors()['confPassword'] ?></span>
                    <?php endif; ?>
                    <br>

                    <input type="number" name="age" placeholder="age" value="<?php echo isset($_POST['age']) ? $_POST['age'] : "" ?>" required>
                    <?php if (isset($this->getErrors()['age'])): ?>
                        <span class="error"><?php echo $this->getErrors()['age'] ?></span>
                    <?php endif; ?>
                    <br>

                    <input type="text" name="phone" placeholder="phone number" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : "" ?>">
                    <?php if (isset($this->getErrors()['phone'])): ?>
                        <span class="error"><?php echo $this->getErrors()['phone'] ?></span>
                    <?php endif; ?>
                    <br>

                    <select name="admin">
                        <option value="0" <?php echo isset($_POST['admin']) && $_POST['admin'] === "0" ? "selected" : ""?>>User</option>
                        <option value="1" <?php echo isset($_POST['admin']) && $_POST['admin'] === "1" ? "selected" : ""?>>Admin</option>
                    </select>
                    <?php if (isset($this->getErrors()['admin'])): ?>
                        <span class="error"><?php echo $this->getErrors()['admin'] ?></span>
                    <?php endif; ?>
                    <br>

                    <div>
                        <input type="radio" name="gender" value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'checked' : ''; ?>> Male
                        <input type="radio" name="gender" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'checked' : ''; ?>> Female
                        <input type="radio" name="gender" value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Other') ? 'checked' : ''; ?>> Other
                    </div>
                    <?php if (isset($this->getErrors()['gender'])): ?>
                        <span class="error"><?php echo $this->getErrors()['gender'] ?></span>
                    <?php endif; ?>
                    <br>

                    <label><input type="checkbox" name="terms" value="agree" <?php echo (isset($_POST['terms']) && $_POST['terms'] === 'agree') ? 'checked' : ''; ?>> I agree to the terms and conditions</label>
                    <?php if (isset($this->getErrors()['terms'])): ?>
                        <span class="error"><?php echo $this->getErrors()['terms'] ?></span>
                    <?php endif; ?>
                    <br>

                    <input type="submit" value="Register" name="registerNewUser">
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editUserModal" class="editModal">
            <div class="form-container">
                <div class="modal-header">
                    <h4>Update username</h4>
                    <span class="closeEditUserModal">&times;</span>
                </div>

                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="userId" id="editUserId">

                    <input type="text" name="username" id="editUsername" placeholder="Username" required>
                    <?php if (isset($this->getErrors()['username'])): ?>
                        <span class="error"><?php echo $this->getErrors()['username']; ?></span>
                    <?php endif; ?>
                    <br>

                    <input type="email" name="email" id="editEmail" placeholder="Email" required>
                    <?php if (isset($this->getErrors()['email'])): ?>
                        <span class="error"><?php echo $this->getErrors()['email']; ?></span>
                    <?php endif; ?>
                    <br>

                    <input type="submit" value="Save changes" name="editUser">
                </form>
            </div>
        </div>

        <!-- Delete One user Modal -->
        <div id="deleteOneUserModal" class="modal deleteOneUserModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Confirm Deletion</h4>
                    <span class="cancelDeletion close">&times;</span>
                </div>
                <p>Are you sure you want to delete this account <span class="permanently">permanently</span>?</p>

                <div class="deleteOneUserModal-buttons">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="userId" id="deleteUserId">
                        <button class="delete-button" type="submit" name="deleteUser">Delete</button>
                    </form>

                    <button class="cancelConfirmDeleteUser cancelDeletion">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<script src="/assets/js/modal.js"></script>
