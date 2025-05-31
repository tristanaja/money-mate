<div id="editBudgetModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-99 hidden">
    <div class="bg-gradient-to-br from-[#0b192c] to-[rgba(11,25,44,0.75)] backdrop-blur-sm p-6 rounded-xl w-[90%] max-w-md text-white">
        <h2 class="text-xl font-bold mb-4">Edit Budget</h2>
        <label class="block text-[0.8rem] font-normal mb-1">
            Current Budget
        </label>
        <div class="w-full p-2 rounded bg-[#1e3a5f] border border-white-600 mb-4">
            Rp <?= number_format($currentBudget, 0, '.', ',') ?>
        </div>
        <form action="processes/budget/edit_budget_process.php" method="POST" class="">
            <label class="block text-[0.8rem] font-normal mb-1">
                Amount
            </label>
            <div class="flex flex-row items-center">
                <div class="w-[10%] p-2 rounded-l bg-transparent border-t border-b border-l border-gray-600">
                    <p class="font-bold text-base">Rp</p>
                </div>
                <input type="number" name="amount" required placeholder="Enter add/subtract amount"
                    class="w-full p-2 rounded-r bg-transparent border-t border-b border-r border-gray-600">
            </div>

            <div class="flex gap-4 mt-4">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="action" value="add" class="peer hidden" required>
                    <div class="w-5 h-5 rounded-full border-2 border-white peer-checked:border-[#ff6500] peer-checked:bg-[#ff6500] transition-all duration-200"></div>
                    <span class="ml-2 text-white">Add</span>
                </label>

                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="action" value="subtract" class="peer hidden" required>
                    <div class="w-5 h-5 rounded-full border-2 border-white peer-checked:border-[#ff6500] peer-checked:bg-[#ff6500] transition-all duration-200"></div>
                    <span class="ml-2 text-white">Subtract</span>
                </label>
            </div>

            <div class="flex gap-3 mt-8">
                <button type="button" onclick="toggleEditBudget()" class="w-full px-4 py-2 rounded bg-[#1e3e62] hover:bg-gray-700">Cancel</button>
                <button type="submit" class="w-full px-4 py-2 rounded bg-[#ff6500] hover:bg-orange-700">Submit</button>
            </div>
        </form>
    </div>
</div>