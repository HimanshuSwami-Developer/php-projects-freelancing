


<div
    class="relative package-card bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 border <?= $key === 'gold' ? 'border-2 border-yellow-400' : 'border-gray-100' ?>">

    <?php if ($key === 'gold'): ?>
    <div
        class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-600 via-yellow-500 to-amber-400 text-white text-sm font-semibold py-1.5 px-5 rounded-full shadow-lg border border-yellow-300">
        ⭐ Most Popular </div>
    <?php endif; ?>
    <!-- Header Ribbon -->
    <div class="text-center px-4 py-4 rounded-t-2xl text-white 
      <?= $key === 'bronze' ? 'bg-gray-700' : ($key === 'gold' ? 'bg-yellow-500' : 'bg-purple-600') ?>">
        <h3 class="text-xs font-bold">
            <?= htmlspecialchars($package['payment_note']) ?>
        </h3>
    </div>

    <div class="text-center px-6 flex flex-col h-[90%] py-2">
        <!-- Title -->
        <div class="text-left">
            <h3 class="text-xl font-bold text-gray-900 mb-1">
                <?= htmlspecialchars($package['name']) ?>
            </h3>
            <p class="text-gray-600 text-sm">
                <?= htmlspecialchars($package['subtitle']) ?>
            </p>
        </div>

        <!-- Pricing -->
        <div class="text-left my-2 p-2 bg-gradient-to-br 
        <?= $key === 'bronze' ? 'from-gray-50 to-gray-100' : ($key === 'gold' ? 'from-yellow-50 to-amber-50' : 'from-purple-50 to-indigo-50') ?> 
        rounded-xl">
            <div class="flex items-center justify-center gap-2">
                <s class="text-gray-400">£
                    <?= number_format($package['original_price'], 2) ?>
                </s>
                <span class="text-lg font-bold text-gray-900">£
                    <?= number_format($package['sale_price'], 2) ?>
                </span>
            </div>
        </div>
        <!-- ✅ Grouped Features -->
        <div class="mb-4 font-semibold text-justify">
            <?php if (!empty($package['feature_groups']) && is_array($package['feature_groups'])): ?>
            <?php foreach ($package['feature_groups'] as $group): ?>
            <h4 id=($key === 'gold')?"heading_gold":"heading_platinum" class="text-md font-semibold text-gray-900 mb-2 border-b border-gray-200 pb-1">
                <?= htmlspecialchars($group['heading'] ?? '') ?>:
            </h4>
            <?php if (!empty($group['features']) && is_array($group['features'])): ?>
         <ul id=($key === 'gold')?"menu_gold":"menu_platinum" class="<?php echo str_contains(trim($heading), 'Everything in') ? 'hidden space-y-1 mb-3' : 'space-y-1 mb-3'; ?>">
                <?php foreach ($group['features'] as $feature): ?>
                <li class="flex items-start gap-2 text-gray-700 text-sm">
                    <?php if (!empty($feature['is_included'])): ?>
                    <svg class="w-5 h-5 mt-0.5 text-green-800 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>
                        <?= htmlspecialchars($feature['text'] ?? '') ?>
                    </span>
                    <?php else: ?>
                    <svg class="w-5 h-5 mt-0.5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 01-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 01-1.414-1.414L8.586 10 3.636 5.05a1 1 0 111.414-1.414L10 8.586z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-500">
                        <?= htmlspecialchars($feature['text'] ?? '') ?>
                    </span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-sm text-gray-500">No features available for this plan.</p>
            <?php endif; ?>
        </div>


        <!-- Important Notes -->
        <?php if (!empty($package['important_notes'])): ?>
        <div class="border-t border-gray-200 pt-3 mb-3">
            <ul class="text-xs text-orange-700 space-y-1">
                <?php foreach ($package['important_notes'] as $note): ?>
                <li class="flex items-start gap-1">
                    <svg class="w-3 h-3 mt-1 text-orange-700 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="5"></circle>
                    </svg>
                    <span>
                        <?= htmlspecialchars($note) ?>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- CTA Button -->
        <div class="mt-auto py-4">
            <button
                class="select-package-btn w-full py-3 rounded-xl font-bold text-sm transition-all duration-300 transform hover:scale-105 hover:shadow-lg 
          <?= $key === 'bronze' ? 'bg-gray-700 text-white' : ($key === 'gold' ? 'bg-yellow-500 text-white' : 'bg-purple-600 text-white') ?>"
                data-date="<?= htmlspecialchars($formattedDate) ?>"
                data-package="<?= htmlspecialchars($package['name']) ?>"
                data-package-id="<?= htmlspecialchars($package['id']) ?>"
                data-package-price="<?= htmlspecialchars($package['sale_price']) ?>"
                data-original-price="<?= htmlspecialchars($package['original_price']) ?>"
                data-course="<?= htmlspecialchars($course_name) ?>" data-price="<?= htmlspecialchars($d['price']) ?>"
                data-quantity="1" <?=!$isBookable ? 'disabled' : '' ?>>
                Get
                <?= htmlspecialchars($package['name']) ?> Plan
            </button>
        </div>
    </div>
</div>