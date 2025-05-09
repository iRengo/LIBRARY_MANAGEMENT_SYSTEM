<!DOCTYPE html>
<html lang="en">

<head>
    <title>Librarian Catalog </title>
    <link rel="stylesheet" href="LIBRARIAN_SETTINGS.CSS">



</head>

<body>
    <?php include 'HEADER-NAVBAR.PHP' ?>
<!-- Content HERE -->
<div class="settings-container">
    <div class="settings-box">
        <div class="settings-header">
            <h2>SETTINGS</h2>
        <div class="settings-buttons">
            <button class="tab active" data-tab="account">Account</button>
            <button class="tab" data-tab="fines">Fines</button>
        </div>

        </div>
        <p class="description">Manage your account settings and preferences</p>

        <h3 class="sub-heading">Profile</h3>
        <p class="description">Set your account details</p>

        <div class="form-row">
        <div class="form-group">
            <label>Librarian ID</label>
                <input type="number" inputmode="numeric" pattern="[0-9]*">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group full-width">
                <label>Email</label>
                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>

            </div>
        </div>
    </div>

    <div class="settings-box">
        <h3 class="sub-heading">CHANGE PASSWORD</h3>

        <div class="form-row">
            <div class="form-group">
                <label>New password</label>
                <input type="password">
            </div>
            <div class="form-group">
                <label>Confirm password</label>
                <input type="password">
            </div>
        </div>

        <div class="button-group">
            <button class="primary">Change</button>
            <button class="secondary">Cancel</button>
        </div>
    </div>

    <div class="action-buttons">
        <button class="secondary">Edit</button>
        <button class="primary">Save</button>
    </div>
</div>
<!-- Content HERE -->

</body>

</html>