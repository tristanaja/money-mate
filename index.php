<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/.config/auth_guard.php';
require_once __DIR__ . '/includes/auth_process_essentials.php';
require_once __DIR__ . '/features/budget_services.php';

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);

$db = (new Database())->connect();
$username = (new Auth_Services($db))->getUsername();
$budgetData = (new budget_services($db))->getBudgets();
$currentBudget = !empty($budgetData) ? $budgetData[0]['amount'] : 0.0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoneyMate</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0a0a0a] text-white min-h-screen m-0 px-8 py-8 flex items-center flex-col">
    <?php if ($error): ?>
        <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-[#14233C] text-black w-[90%] max-w-md p-6 rounded-xl shadow-lg flex flex-col justify-center">
                <h2 class="text-[2em] font-bold text-center text-[#c62424] mb-2">ERROR</h2>
                <p class="text-center text-[1em] mb-[2.5em] text-[#fafafa]"><?= htmlspecialchars($error) ?></p>
                <button onclick="closeModal('errorModal')" class="bg-[#ff8c00] hover:bg-orange-600 rounded-full text-[#fafafa] text-2xl font-bold px-6 py-2">Close</button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-[#14233C] text-black w-[90%] max-w-md p-6 rounded-xl shadow-lg flex flex-col justify-center">
                <h2 class="text-[2em] font-bold text-center text-[#00c853] mb-2">SUCCESS</h2>
                <p class="text-center text-[1em] mb-[2.5em] text-[#fafafa]"><?= htmlspecialchars($success) ?></p>
                <button onclick="closeModal('successModal')" class="bg-[#00c853] hover:bg-green-700 rounded-full text-[#fafafa] text-2xl font-bold px-6 py-2">Close</button>
            </div>
        </div>
    <?php endif; ?>

    <div class="w-full flex justify-between items-center">
        <!-- Logo -->
        <img data-url="index.php" onclick="goToPage(this)" src="assets/images/logo.png" alt="MoneyMate Logo" class="cursor-pointer w-[10em] h-[3.5em]">

        <!-- Hamburger button (visible on small screens) -->
        <img onclick="toggleMobileMenu()" src="assets/images/hamburger_icon.svg" alt="Hamburger" class="xl:hidden w-8 h-8 cursor-pointer">

        <!-- Navigation (desktop) -->
        <nav class="hidden xl:flex">
            <ul class="flex gap-8 items-center">
                <li class="transition-all duration-200 ease-in-out transform hover:scale-125 hover:mx-2">
                    <a href="index.php" class="transition-all duration-200 ease-in-out text-[#fafafa] hover:text-[#ff8c00]">Home</a>
                </li>
                <li class="transition-all duration-200 ease-in-out transform hover:scale-125 hover:mx-2">
                    <a href="#" class="text-white hover:text-orange-500">Expense Category</a>
                </li>
                <li class="transition-all duration-200 ease-in-out transform hover:scale-125 hover:mx-2">
                    <a href="#" class="text-white hover:text-orange-500">Expense Report</a>
                </li>
                <li class="group transition-all ease-in-out duration-75 hover:bg-orange-600 flex items-center gap-2 border-[1px] hover:border-0 py-2 pl-4 pr-2 rounded-full cursor-pointer">
                    <p class="transition-all ease-in-out duration-75 group-hover:hidden"><?= $username ?></p>
                    <a href="processes/log_out_process.php" class="transition-all ease-in-out duration-75 hidden group-hover:block">Log Out</a>
                    <img src="assets/images/profile.png" alt="Profile Icon" class="w-[2rem] h-[2rem]">
                </li>
            </ul>
        </nav>
    </div>

    <!-- Mobile Sidebar Menu -->
    <div id="mobileMenu" class="xl:hidden fixed top-0 right-0 w-64 h-full bg-[#0f1114] shadow-lg z-50 transform translate-x-full opacity-0 transition-all duration-200 ease-in-out pointer-events-none">
        <!-- Header -->
        <div class="bg-[#1b2a42] py-6 px-4 rounded-b-3xl flex flex-col items-center">
            <img src="assets/images/profile.png" alt="Profile" class="w-24 h-24 rounded-full mb-3">
            <p class="text-white font-bold text-sm text-center uppercase tracking-wide"><?= strtoupper($username) ?></p>
        </div>

        <!-- Menu -->
        <ul class="mt-6 flex flex-col text-white px-6">
            <div class="flex flex-col gap-8">
                <li class="group transition-all ease-in-out duration-150 flex justify-between items-center hover:border-b-2 hover:border-orange-600 hover:pb-3 cursor-pointer">
                    <a href="index.php" class="text-base">Homepage</a>
                    <img src="assets/images/home_menu_icon.svg" alt="Home Icon">
                </li>
                <li class="group transition-all ease-in-out duration-150 flex justify-between items-center hover:border-b-2 hover:border-orange-600 hover:pb-3 cursor-pointer">
                    <a href="#" class="text-base">Expense Category</a>
                    <img src="assets/images/expense_category_menu_icon.svg" alt="Expense Category Icon">
                </li>
                <li class="group transition-all ease-in-out duration-150 flex justify-between items-center hover:border-b-2 hover:border-orange-600 hover:pb-3 cursor-pointer">
                    <a href="#" class="text-base">Expense Report</a>
                    <img src="assets/images/expense_report_menu_icon.svg" alt="Expense Report Icon">
                </li>
                <li onclick="toggleMobileMenu()" class="group transition-all ease-in-out duration-150 flex justify-between items-center hover:border-b-2 hover:border-orange-600 hover:pb-3 cursor-pointer">
                    <a href="#" class="text-base">Close</a>
                    <img src="assets/images/close_menu_icon.svg" alt="Close Icon" class="w-5 h-5">
                </li>
            </div>
            <li data-url="processes/log_out_process.php" onclick="goToPage(this)" class="absolute bottom-10 right-6 left-6 group transition-all ease-in-out duration-150 flex justify-between items-center bg-orange-600 rounded-md p-2 hover:border-b-2 border-orange-600 hover:pb-3 cursor-pointer">
                <a class="text-base">Log Out</a>
                <img src="assets/images/log_out_icon.svg" alt="Expense Report Icon" class="w-6 h-6">
            </li>
        </ul>
    </div>

    <!-- Main Budget & Saving Goal Card Section -->
    <div class="w-full lg:w-[50%] mt-10 space-y-6">

        <!-- Budget + Saving Goal Card -->
        <div class="bg-[#1b2a42] rounded-2xl overflow-hidden text-white">
            <!-- Budget Row -->
            <div class="bg-[#1e3a5f] px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">BUDGET</h2>
                <p id="budgetAmount" class="text-xl font-light">Rp <?= number_format($currentBudget, 0, ',', '.') ?></p>
            </div>

            <!-- Saving Goal Row -->
            <div class="bg-[#0f1c30] px-6 py-4 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold">SAVING GOAL</h3>
                    <p class="text-sm text-gray-400">by 5 March</p>
                </div>
                <p class="text-xl font-light">Rp 2,000,000</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-center gap-4">
            <!-- Edit Budget Button -->
            <button id="editBudgetButton" class="bg-[#1e3a5f] hover:bg-[#0f1c30] text-white py-3 px-5 rounded-xl font-bold w-full text-[10px]">
                EDIT BUDGET
            </button>

            <!-- Plus Button -->
            <img data-url="processes/log_out_process.php" onclick="goToPage(this)" src="assets/images/add_expense_button.svg" alt="add expense" class="transition-all ease-in-out duration-150 hover:scale-125 hover:mx-1 md:hover:mx-2 w-10 h-10 cursor-pointer">

            <!-- Edit Saving Goal Button -->
            <button class="bg-[#1e3a5f] hover:bg-[#0f1c30] text-white py-3 px-5 rounded-xl font-bold w-full text-[10px]">
                EDIT SAVING GOAL
            </button>
        </div>


    </div>

    <?php include __DIR__ . '/components/edit_budget_pops.php'; ?>
    <script src="public/js/function_helper.js"></script>
    <script src="public/js/pops_helper.js"></script>
    <script>
        window.currentBudget = <?= json_encode($currentBudget) ?>;
    </script>
</body>

</html>