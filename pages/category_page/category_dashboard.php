<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../includes/auth_process_essentials.php';
require_once __DIR__ . '/../../features/category_services.php';

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);

$db = (new Database())->connect();
$username = (new Auth_Services($db))->getUsername();
$categoryService = new category_services($db);
$categories = $categoryService->getCategories();
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
    <!-- EXPENSE CATEGORIES SECTION -->
    <div class="w-full mt-10">
        <h2 class="text-xl font-bold mb-6">EXPENSE CATEGORIES</h2>

        <div class="flex flex-col gap-4">
            <?php foreach ($categories as $category):
                $id = $categoryService->getIdByCategory($category['name'])['id'] ?? null;
            ?>
                <div class="bg-[#183153] px-8 py-4 rounded-lg flex justify-between items-center">
                    <div>
                        <h3 class="text-[1.3em] font-bold"><?= htmlspecialchars($category['name']) ?></h3>
                        <p class="text-[0.8em] font-light text-[#ff6500]"><?= $categoryService->getExpenseCount($id) ?> Expenses</p>
                    </div>
                    <img onclick="toggleEditCategory(<?= $id ?>)" src="../../assets/images/edit_category_icon.svg" alt="Edit" class="w-5 h-5 cursor-pointer">
                </div>

                <?php require __DIR__ . '/../../components/edit_category_pops.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- FLOATING ACTION BUTTON -->
    <button id="addCategoryButton"
        class="fixed bottom-6 right-6 pb-1 pl-[0.08em] bg-[#ff6500] hover:bg-orange-700 text-white w-14 h-14 flex items-center justify-center text-3xl font-bold rounded-full shadow-lg z-40">
        +
    </button>

    <?php include __DIR__ . '/../../components/add_category_pops.php'; ?>
    <script src="../../public/js/function_helper.js"></script>
    <script src="../../public/js/pops_category_helper.js"></script>
    <script src="../../public/js/close_modal_category.js"></script>
    <script src="../../public/js/edit_category_pops.js"></script>
</body>

</html>