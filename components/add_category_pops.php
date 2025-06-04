<div id="addCategoryModal" class="backdrop-blur-sm fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-gradient-to-br from-[#0b192c] to-[rgba(11,25,44,0.75)] p-6 rounded-xl w-[90%] max-w-md text-white">
        <h2 class="text-xl font-bold mb-6">Add Category</h2>

        <form action="../../processes/category/add_category_process.php" method="POST">
            <!-- Category Name Input -->
            <input type="text" name="category_name" required placeholder="Category Name"
                class="w-full p-3 rounded border border-gray-500 bg-transparent mb-6 placeholder-gray-400 text-white text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="button" onclick="toggleAddCategory()"
                    class="w-full py-2 rounded bg-[#1e3e62] hover:bg-gray-700 text-white font-semibold">
                    Cancel
                </button>
                <button type="submit"
                    class="w-full py-2 rounded bg-[#ff6500] hover:bg-orange-700 text-white font-semibold">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>