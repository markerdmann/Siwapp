<?php use_helper('Date') ?>
<?php include_partial('configuration/navigation') ?>

<div id="settings-wrapper" class="content">
  
  <form method="post" action="<?php echo url_for('@templates') ?>">
    <?php echo $_csrf->renderHiddenFields() ?>
    <table id="listing" class="listing">
      <thead>
        <tr>
          <th class="xs">
            <input type="checkbox" name="select_all" id="select_all" class="selectAll" rel="all" />
          </th>
          <th><?php echo __('Name') ?></th>
          <th class="medium"><?php echo __('Updated at') ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($templates as $i => $template): ?>
          <tr id ="<?php echo "template-{$template->getId()}" ?>" class="template <?php echo "template-{$template->getId()}" ?><?php echo $template->isDefault() ? ' default' : null ?>">
            <td class="check">
              <?php if ($template->isDefault()): ?>
                <?php echo image_tag('icons/asterisk_yellow.png', 'alt=default template class=check') ?>
              <?php else: ?>
                <input type="checkbox" name="ids[]" class="check" value="<?php echo $template->getId() ?>" rel="item" />
              <?php endif ?>
            </td>
            <td><?php echo $template->getName() ?></td>
            <td><?php echo format_date($template->getUpdatedAt()) ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
      <tfoot>
        <tr class="noborder">
          <td colspan="3" class="listing-options">
            <?php echo gButton(__('Create new template'), 'id=createNew type=button class=action create rel=templates:add') ?>
            <?php echo gButton(__('Delete selected'), 'id=deleteSelected type=button class=action delete rel=templates:delete') ?>
            <?php echo gButton(__('Mark as default'), 'id=setAsDefault type=button class=action default rel=templates:default') ?>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
  
</div>