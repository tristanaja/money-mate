<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth_process_essentials.php';
require_once __DIR__ . '/../../features/budget_services.php';
require_once __DIR__ . '/../../features/expense_services.php';
require_once __DIR__ . '/../../features/saving_goal_services.php';
require_once __DIR__ . '/../../features/category_services.php';

$db = (new Database())->connect();
$username = (new Auth_Services($db))->getUsername();
$savingGoalServices = new saving_goal_services($db);
$categoryServices = new category_services($db);
$budgetServices = new budget_services($db);
$expenseServices = new expense_services($db, $budgetServices);
$savingGoalServices->checkAndUpdateSavingGoalStatus();

$savingGoalData = $savingGoalServices->getsavingGoal();
$currentBudget = $budgetServices->getBudgets()[0]['amount'] ?? 0.0;
$currentSavingGoalAmount = !empty($savingGoalData) ? $savingGoalData[0]['amount'] : 0.0;
$currentSavingGoalStatus = !empty($savingGoalData) ? $savingGoalData[0]['status'] : 'NOT ACHIEVED';
$categories = $categoryServices->getCategories();
$totalExpenses = $expenseServices->getExpenseSum() ?? 0.0;

$spare = $currentBudget - $currentSavingGoalAmount;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0a0a0a] text-white min-h-screen m-0 px-8 py-8 flex items-center flex-col">
    <div class="w-full flex justify-between items-center">
        <!-- Logo -->
        <img data-url="index.php" onclick="goToPage(this)" src="../../assets/images/logo.png" alt="MoneyMate Logo" class="cursor-pointer w-[10em] h-[3.5em]">

        <!-- Hamburger button (visible on small screens) -->
        <img onclick="toggleMobileMenu()" src="../../assets/images/hamburger_icon.svg" alt="Hamburger" class="xl:hidden w-8 h-8 cursor-pointer">

        <!-- Navigation (desktop) -->
        <nav class="hidden xl:flex">
            <ul class="flex gap-8 items-center">
                <li data-url="../../index.php" onclick="goToPage(this)" class="transition-all duration-200 ease-in-out transform hover:scale-125 hover:mx-2">
                    <a class="transition-all duration-200 ease-in-out text-[#fafafa] hover:text-[#ff8c00] cursor-pointer">Home</a>
                </li>
                <li data-url="category_dashboard.php" onclick="goToPage(this)" class="transition-all duration-200 ease-in-out transform hover:scale-125 hover:mx-2">
                    <a class="text-white hover:text-orange-500 cursor-pointer">Expense Category</a>
                </li>
                <li data-url="../../pages/expense_report/expense_report.php" onclick="goToPage(this)" class="transition-all duration-200 ease-in-out transform hover:scale-125 hover:mx-2">
                    <a class="text-white hover:text-orange-500 cursor-pointer">Expense Report</a>
                </li>
                <li class="group transition-all ease-in-out duration-75 hover:bg-orange-600 flex items-center gap-2 border-[1px] hover:border-0 py-2 pl-4 pr-2 rounded-full cursor-pointer">
                    <p class="transition-all ease-in-out duration-75 group-hover:hidden"><?= $username ?></p>
                    <a href="../../processes/log_out_process.php" class="transition-all ease-in-out duration-75 hidden group-hover:block">Log Out</a>
                    <img src="../../assets/images/profile.png" alt="Profile Icon" class="w-[2rem] h-[2rem]">
                </li>
            </ul>
        </nav>
    </div>

    <!-- Mobile Sidebar Menu -->
    <div id="mobileMenu" class="xl:hidden fixed top-0 right-0 w-64 h-full bg-[#0f1114] shadow-lg z-50 transform translate-x-full opacity-0 transition-all duration-200 ease-in-out pointer-events-none">
        <!-- Header -->
        <div class="bg-[#1b2a42] py-6 px-4 rounded-b-3xl flex flex-col items-center">
            <img src="../../assets/images/profile.png" alt="Profile" class="w-24 h-24 rounded-full mb-3">
            <p class="text-white font-bold text-sm text-center uppercase tracking-wide"><?= strtoupper($username) ?></p>
        </div>

        <!-- Menu -->
        <ul class="mt-6 flex flex-col text-white px-6">
            <div class="flex flex-col gap-8">
                <li data-url="../../index.php" onclick="goToPage(this)" class="group transition-all ease-in-out duration-150 flex justify-between items-center hover:border-b-2 hover:border-orange-600 hover:pb-3 cursor-pointer">
                    <a class="text-base">Home</a>
                    <img src="../../assets/images/home_menu_icon.svg" alt="Home Icon">
                </li>
                <li data-url="../../pages/category_page/category_dashboard.php" onclick="goToPage(this)" class="group transition-all ease-in-out duration-150 flex justify-between items-center hover:border-b-2 hover:border-orange-600 hover:pb-3 cursor-pointer">
                    <a class="text-base">Expense Category</a>
                    <img src="../../assets/images/expense_category_menu_icon.svg" alt="Expense Category Icon">
                </li>
                <li data-url="../../pages/expense_report/expense_report.php" onclick="goToPage(this)" class="group transition-all ease-in-out duration-150 flex justify-between items-center hover:border-b-2 hover:border-orange-600 hover:pb-3 cursor-pointer">
                    <a class="text-base">Expense Report</a>
                    <img src="../../assets/images/expense_report_menu_icon.svg" alt="Expense Report Icon">
                </li>
                <li onclick="toggleMobileMenu()" class="group transition-all ease-in-out duration-150 flex justify-between items-center hover:border-b-2 hover:border-orange-600 hover:pb-3 cursor-pointer">
                    <a href="#" class="text-base">Close</a>
                    <img src="../../assets/images/close_menu_icon.svg" alt="Close Icon" class="w-5 h-5">
                </li>
            </div>
            <li data-url="../../processes/log_out_process.php" onclick="goToPage(this)" class="absolute bottom-10 right-6 left-6 group transition-all ease-in-out duration-150 flex justify-between items-center bg-orange-600 rounded-md p-2 hover:border-b-2 border-orange-600 hover:pb-3 cursor-pointer">
                <a class="text-base">Log Out</a>
                <img src="../../assets/images/log_out_icon.svg" alt="Expense Report Icon" class="w-6 h-6">
            </li>
        </ul>
    </div>

    <h2 class="w-full text-lg font-bold mb-4 mt-20">EXPENSE REPORT</h2>

    <div class=" w-full bg-gray-900 rounded border-[0.5px] border-white">
        <div class="flex justify-between items-center p-4 bg-[#1e3e62] rounded-t">
            <span class="font-bold">Total Expenses</span>
            <span class="font-bold">Rp <?= number_format($totalExpenses, 0, ',', '.') ?></span>
        </div>
        <?php foreach ($categories as $category): ?>
            <div class="flex justify-between items-center p-4 border-t-[0.5px] border-white bg-[#0b192c]">
                <div>
                    <div class="font-light"><?= htmlspecialchars($category['name']) ?></div>
                    <div class="text-[12px] text-orange-500 font-light"><?= htmlspecialchars($categoryServices->getExpenseCount($category['id'])) ?> Expense(s)</div>
                </div>
                <div class="font-light">Rp <?= number_format($categoryServices->getExpenseSum($category['id']), 0, ',', '.') ?></div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="w-full bg-gray-900 mt-6 rounded border-[0.5px] border-white">
        <div class="flex justify-between items-center p-4 border-b-[0.5px] border-white bg-[#1e3e62] rounded-t">
            <span class="font-bold">Target Savings</span>
            <span class="font-bold">Rp <?= number_format($currentSavingGoalAmount, 0, ',', '.') ?></span>
        </div>
        <div class="flex justify-between items-center p-4 border-b-[0.5px] border-white bg-[#1e3e62]">
            <span class="font-bold">Current Budget</span>
            <span class="font-bold">Rp <?= number_format($currentBudget, 0, ',', '.') ?></span>
        </div>
        <div class="flex justify-between items-center p-4 border-b-[0.5px] border-white bg-[#0b192c]">
            <span>Status</span>
            <span class="text-[#ff6500] font-bold"><?= $currentSavingGoalStatus ?>!</span>
        </div>
        <?php if ($currentSavingGoalStatus === 'BONUS' && $spare > 0): ?>
            <div class="flex justify-between items-center p-4 bg-[#0b192c]">
                <span class="text-[#24c642] font-bold">Bonus</span>
                <span class="text-[#24c642] font-bold">Rp <?= number_format($spare, 0, ',', '.') ?></span>
            </div>
        <?php elseif ($currentSavingGoalStatus === 'NOT ACHIEVED' && $spare < 0): ?>
            <div class="flex justify-between items-center p-4 bg-[#0b192c]">
                <span class="text-[#c62424] font-bold">Overspend</span>
                <span class="text-[#c62424] font-bold">Rp <?= number_format($spare, 0, ',', '.') ?></span>
            </div>
        <?php endif; ?>
    </div>
    <script src="../../public/js/function_helper.js"></script>
</body>

</html>