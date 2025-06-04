<div id="editSavingGoalModal" class="backdrop-blur-sm fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-gradient-to-br from-[#0b192c] to-[rgba(11,25,44,0.75)]  p-6 rounded-xl w-[90%] max-w-md text-white">
        <h2 class="text-xl font-bold mb-4">Edit Saving Goal</h2>

        <form action="processes/saving_goal/edit_saving_goal_process.php" method="POST">
            <!-- Amount -->
            <label class="block text-[0.8rem] font-normal mb-1">Goal Amount</label>
            <div class="flex flex-row items-center mb-4">
                <div class="w-[10%] p-2 rounded-l bg-transparent border-t border-b border-l border-gray-600">
                    <p class="font-bold text-base">Rp</p>
                </div>
                <input type="number" name="amount" required placeholder="Enter target amount"
                    class="w-full p-2 rounded-r bg-transparent border-t border-b border-r border-gray-600">
            </div>

            <!-- Target Month -->
            <label class="block text-[0.8rem] font-normal mb-1">Target Month</label>
            <div class="relative mb-4">
                <select name="target_month" required
                    class="w-full p-2 pr-10 rounded bg-transparent border border-gray-600 text-white appearance-none bg-[#0b192c]">
                    <?php
                    $months = [
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December'
                    ];
                    foreach ($months as $num => $name) {
                        echo "<option value=\"$num\">$name</option>";
                    }
                    ?>
                </select>

                <!-- Custom dropdown arrow -->
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>


            <!-- Target Year -->
            <label class="block text-[0.8rem] font-normal mb-1">Target Year</label>
            <input type="number" name="target_year" required min="<?= date('Y') ?>" max="<?= date('Y') + 10 ?>"
                class="w-full p-2 rounded bg-transparent border border-gray-600 mb-6"
                placeholder="Enter target year">

            <div class="flex gap-3 mt-4">
                <button type="button" onclick="toggleEditSavingGoal()" class="w-full px-4 py-2 rounded bg-[#1e3e62] hover:bg-gray-700">Cancel</button>
                <button type="submit" class="w-full px-4 py-2 rounded bg-[#ff6500] hover:bg-orange-700">Submit</button>
            </div>
        </form>
    </div>
</div>