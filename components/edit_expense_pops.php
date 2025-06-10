<?php
require_once __DIR__ . '/../includes/auth_process_essentials.php';
require_once __DIR__ . '/../features/category_services.php';

$db = (new Database())->connect();
$categoryService = new category_services($db);
$categories = $categoryService->getCategories();
$pricePerUnit = $expense['amount'] / $expense['quantity'];
?>

<!-- Edit Expense Modal -->
<div id="editExpenseModal_<?= htmlspecialchars($expense['id']) ?>" class="backdrop-blur-sm fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-gradient-to-br from-[#0b192c] to-[rgba(11,25,44,0.75)] p-6 rounded-xl w-[90%] max-w-md text-white">
        <h2 class="text-xl font-bold mb-6">Edit Expense</h2>

        <form action="processes/expense/edit_expense_process.php" method="POST">
            <!-- Hidden ID -->
            <input type="hidden" name="expense_id" value="<?= htmlspecialchars($expense['id']) ?>">

            <!-- Title -->
            <label class="block text-[0.8rem] font-normal mb-1">Title</label>
            <input type="text" name="title" required placeholder="Expense Title"
                value="<?= htmlspecialchars($expense['title']) ?>"
                class="w-full p-3 rounded border border-gray-500 bg-transparent mb-4 placeholder-gray-400 text-white text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">

            <!-- Description -->
            <label class="block text-[0.8rem] font-normal mb-1">Description</label>
            <textarea name="description" rows="2" required placeholder="Description"
                class="w-full h-[100px] p-3 rounded border border-gray-500 bg-transparent mb-3 placeholder-gray-400 text-white text-sm resize-none focus:outline-none focus:ring-2 focus:ring-orange-500"><?= htmlspecialchars($expense['description']) ?></textarea>

            <!-- Amount -->
            <label class="block text-[0.8rem] font-normal mb-1">Price</label>
            <div class="flex flex-row items-center mb-6">
                <div class="w-[10%] p-2 rounded-l bg-transparent border-t border-b border-l border-gray-600">
                    <p class="font-bold text-base">Rp</p>
                </div>
                <input type="number" name="unit_amount" required placeholder="Price per unit"
                    value="<?= $pricePerUnit ?>"
                    class="w-full p-2 rounded-r bg-transparent border-t border-b border-r border-gray-600">
            </div>

            <!-- Quantity + Category -->
            <div class="w-full flex justify-center items-center mb-6 gap-4">
                <div class="w-[50%] flex flex-row items-center justify-center">
                    <input type="number" name="quantity" required placeholder="Quantity"
                        value="<?= htmlspecialchars($expense['quantity']) ?>"
                        class="overflow-clip w-full p-2 rounded-l bg-transparent border-t border-b border-l border-gray-600">
                    <div class="w-[10%] py-2 px-4 rounded-r bg-transparent border-t border-b border-r border-gray-600 flex items-center justify-center">
                        <p class="font-bold text-base">x</p>
                    </div>
                </div>
                <div class="w-full relative">
                    <select name="category_id" required
                        class="w-full p-2 pr-10 rounded bg-transparent border border-gray-600 text-white appearance-none bg-[#0b192c]">
                        <option value="" disabled>Select Category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['id']) ?>"
                                <?= $cat['id'] == $expense['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="button" onclick="toggleEditExpense(<?= htmlspecialchars($expense['id']) ?>)"
                    class="w-full py-2 rounded bg-[#1e3e62] hover:bg-gray-700 text-white font-semibold">
                    Cancel
                </button>
                <button type="submit"
                    class="w-full py-2 rounded bg-[#ff6500] hover:bg-orange-700 text-white font-semibold">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>