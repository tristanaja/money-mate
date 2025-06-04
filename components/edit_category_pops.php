<div id="editCategoryModal_<?= $id ?>" class="backdrop-blur-sm fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-gradient-to-br from-[#0b192c] to-[rgba(11,25,44,0.75)] p-6 rounded-2xl w-[90%] max-w-md text-white">
        <h2 class="text-xl font-bold mb-6">Edit Category</h2>

        <form action="../../processes/category/edit_category_process.php" method="POST">
            <!-- Hidden input for category ID -->
            <input type="hidden" name="category_id" value="<?= $id; ?>">

            <!-- Category Name Input -->
            <input
                type="text"
                name="category_name"
                id="editCategoryName"
                class="w-full p-3 rounded border border-gray-500 bg-transparent mb-6 placeholder-gray-400 text-white text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">

            <!-- Action Buttons -->
            <div class="flex gap-4 mb-4">
                <button
                    type="button"
                    onclick="toggleEditCategory(<?= $id ?>)"
                    class="w-full py-2 rounded bg-[#1e3e62] hover:bg-gray-700 text-white font-semibold">
                    Cancel
                </button>
                <button
                    type="submit"
                    class="w-full py-2 rounded bg-[#ff6500] hover:bg-orange-700 text-white font-semibold">
                    Edit
                </button>
            </div>
        </form>
    </div>
</div>