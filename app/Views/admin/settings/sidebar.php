<div class="card">

  <div class="card-header border-bottom">
    <h3 class="card-title m-0">Settings</h3>
  </div>
  <div class="list-group">
    <a href="<?= base_url('settings/general'); ?>" class="list-group-item list-group-item-action <?= ($tab == 'general') ? 'active' : ''; ?>" aria-current="true">
      General Settings
    </a>
    <a href="<?= base_url('settings/company'); ?>" class="list-group-item list-group-item-action <?= ($tab == 'company') ? 'active' : ''; ?>">
      Company Settings
    </a>
    <a href="<?= base_url('settings/email_templates'); ?>" class="list-group-item list-group-item-action <?= ($tab == 'email_templates') ? 'active' : ''; ?>"">
      Email Templates
    </a>
  </div>
</div>