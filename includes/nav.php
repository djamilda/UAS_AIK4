<?php
/**
 * Breadcrumb Navigation Component
 * Usage: $breadcrumbs = [['label'=>'Beranda','url'=>'../index.php'], ['label'=>'Detail']]
 */
if (!isset($breadcrumbs)) $breadcrumbs = [];
if (empty($breadcrumbs)) return;
?>
<nav aria-label="breadcrumb" class="relative z-10 bg-slate-900/40 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <ol class="flex items-center gap-1.5 text-sm flex-wrap">
            <li>
                <a href="<?= str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/') - 1) ?>index.php"
                   class="text-white/50 hover:text-emerald-400 transition-colors flex items-center gap-1.5">
                    <i class="fas fa-home text-xs"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <?php foreach ($breadcrumbs as $idx => $crumb): ?>
            <li class="text-white/30"><i class="fas fa-chevron-right text-xs"></i></li>
            <li>
                <?php if (isset($crumb['url']) && $idx < count($breadcrumbs) - 1): ?>
                <a href="<?= htmlspecialchars($crumb['url']) ?>"
                   class="text-white/50 hover:text-emerald-400 transition-colors"><?= htmlspecialchars($crumb['label']) ?></a>
                <?php else: ?>
                <span class="text-emerald-400 font-medium"><?= htmlspecialchars($crumb['label']) ?></span>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>
