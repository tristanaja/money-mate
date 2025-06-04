<!-- Delete Confirmation Modal -->
<div id="deleteCategoryModal_<?= $id ?>" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="bg-[#0b192c] rounded-2xl px-6 py-8 w-[90%] max-w-sm text-white text-center shadow-lg">
        <h2 class="text-2xl font-bold mb-2">ARE YOU SURE?</h2>
        <p class="text-sm text-gray-300 mb-6">Deleted Expense cannot be recycled</p>

        <div class="flex gap-4 justify-center">
            <button
                onclick="toggleDeleteCategory(<?= $id; ?>)"
                class="w-full py-2 rounded-md bg-[#1d3557] hover:bg-[#27496d] text-white font-semibold">
                Cancel
            </button>

            <form action="../../processes/category/delete_category_process.php" method="POST" class="w-full">
                <input type="hidden" name="category_id" value="<?= $id; ?>">
                <button
                    type="submit"
                    class="w-full py-2 rounded-md bg-red-600 hover:bg-red-700 text-white font-semibold">
                    DELETE
                </button>
            </form>
        </div>
    </div>
</div>