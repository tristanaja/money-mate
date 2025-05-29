<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../includes/auth_process_essentials.php';
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0a0a0a] text-white min-h-screen flex items-center justify-center flex-col lg:flex-row px-10 pb-5 gap-[2em] lg:gap-[4em]">
    <!-- Logo -->
    <div class="">
        <img src="../../assets/images/logo.png" alt="logo" class="w-[10em] lg:w-[18em] h-[3.5em] lg:h-[6em]">
    </div>

    <!-- Form Container -->
    <div class="bg-[#14233C] py-8 rounded-3xl w-full lg:w-[30em] px-[3em] flex flex-col justify-center">
        <h2 class="text-[1.5em] md:text-[2em] font-bold text-center mb-[1.5em]">SIGN IN</h2>

        <?php if ($error): ?>
            <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">
                <div class="bg-[#14233C] text-black w-[90%] max-w-md p-6 rounded-xl shadow-lg flex flex-col justify-center">
                    <h2 class="text-[2em] font-bold text-center text-[#c62424] mb-2">ERROR</h2>
                    <p class="text-center text-[1em] mb-[2.5em] text-[#fafafa]"><?= htmlspecialchars($error) ?></p>
                    <button onclick="document.getElementById('errorModal').remove()" class="bg-[#ff8c00] hover:bg-orange-600 rounded-full text-[#fafafa] text-2xl font-bold px-6 py-2">Close</button>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="../../processes/sign_in_process.php" class="space-y-[2em] md:space-y-[3em]">
            <!-- Email -->
            <div class="flex flex-row gap-x-10">
                <img src="../../assets/images/username_email_icon.png" alt="username/email icon" class="hidden md:inline w-[5em] h-[5em]">
                <div class="w-full">
                    <label class="block text-[0.8rem] md:text-[1rem] font-bold mb-1 flex items-center">
                        Email Address
                    </label>
                    <input type="email" name="email" required
                        class="w-full bg-transparent border-b-2 border-white outline-none py-2 px-1 placeholder-gray-400 text-[1em] md:text-[1.4em]" />
                </div>
            </div>

            <!-- Password -->
            <div class="flex flex-row gap-x-10">
                <img src="../../assets/images/password_icon.png" alt="password icon" class="hidden md:inline w-[5em] h-[5em]">
                <div class="w-full">
                    <label class="block text-[0.8rem] md:text-[1rem] font-bold mb-1 flex items-center">
                        Password
                    </label>
                    <input type="password" name="password" required
                        class="w-full bg-transparent border-b-2 border-white outline-none py-2 px-1 placeholder-gray-400 text-[1em] md:text-[1.4em]" />
                </div>
            </div>

            <!-- Submit -->
            <div class="text-center">
                <button type="submit"
                    class="bg-[#ff8c00] hover:bg-orange-600 text-white font-bold py-3 md:py-4 px-6 rounded-full w-full transition text-[15px] md:text-[25px]">
                    SIGN IN
                </button>
            </div>
        </form>

        <!-- Sign Up Link -->
        <p class="mt-7 text-[12px] md:text-[16px] text-center flex flex-col gap-y-[0.5em]">
            Don’t have an account yet?
            <a href="sign_up.php" class="text-white font-bold underline">Sign Up</a>
        </p>
    </div>
</body>

</html>