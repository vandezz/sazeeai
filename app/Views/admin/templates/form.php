<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="max-w-3xl">
    <a href="<?= base_url('admin/templates') ?>" class="text-sm text-gray-400 hover:text-white mb-4 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Templates
    </a>

    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 mt-4">
        <h2 class="text-lg font-semibold text-white mb-6"><?= $template ? 'Edit Template' : 'Create Template' ?></h2>

        <?php if (session()->getFlashdata('errors')): ?>
        <div class="mb-4 bg-red-900/30 border border-red-700 rounded-xl p-4">
            <?php foreach ((array)session()->getFlashdata('errors') as $err): ?>
            <p class="text-sm text-red-400"><?= esc($err) ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="<?= $template ? base_url('admin/templates/' . $template['id']) : base_url('admin/templates') ?>" method="POST" class="space-y-5">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Template Name *</label>
                    <input type="text" name="name" value="<?= esc($template['name'] ?? old('name')) ?>" required
                           class="w-full px-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Category</label>
                    <select name="category" class="w-full px-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <?php foreach (['flyer','social','poster','email','banner','other'] as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($template['category'] ?? '') === $cat ? 'selected' : '' ?>><?= ucfirst($cat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm text-gray-300 mb-1.5">Template Body *
                    <span class="text-xs text-gray-500 font-normal">Use <code class="bg-gray-700 px-1 rounded">{{variable_name}}</code> for placeholders</span>
                </label>
                <textarea name="template_body" required rows="8"
                          class="w-full px-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white text-sm font-mono focus:outline-none focus:ring-2 focus:ring-brand-500 resize-y"><?= esc($template['template_body'] ?? old('template_body')) ?></textarea>
                <p class="text-xs text-gray-500 mt-1">Available variables: {{product_name}}, {{brand_name}}, {{headline}}, {{subheadline}}, {{product_description}}, {{cta_text}}, {{target_audience}}, {{design_style}}, {{color_theme}}, {{aspect_ratio}}, {{ai_platform}}, {{image_mood}}, {{typography_style}}, {{lighting_style}}, {{additional_notes}}</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-gray-300 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" value="<?= esc($template['sort_order'] ?? 0) ?>"
                           class="w-full px-4 py-3 rounded-xl bg-gray-700 border border-gray-600 text-white text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                </div>
                <div class="flex items-end pb-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" <?= ($template['is_active'] ?? 1) ? 'checked' : '' ?>
                               class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500 bg-gray-700 border-gray-600">
                        <span class="text-sm text-gray-300">Active</span>
                    </label>
                </div>
                <div class="flex items-end pb-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_premium" value="1" <?= ($template['is_premium'] ?? 0) ? 'checked' : '' ?>
                               class="w-4 h-4 rounded text-brand-600 focus:ring-brand-500 bg-gray-700 border-gray-600">
                        <span class="text-sm text-gray-300">Pro Only</span>
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl text-sm transition-all">
                    <?= $template ? 'Update Template' : 'Create Template' ?>
                </button>
                <a href="<?= base_url('admin/templates') ?>" class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-gray-300 font-medium rounded-xl text-sm transition-all">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
