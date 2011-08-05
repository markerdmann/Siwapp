jQuery(function($){
  
  var tb = $('table#listing').selecTable();
  
  if (window.siwapp_urls.editRow)
  {
    tb.find('tr.template').rowClick(function(e){
      var id = Tools.getStringId($(this).attr('id'));
      document.location.href = window.siwapp_urls.editRow + '?id=' + id;
    });
    
    tb.find('[rel=templates:add]').click(function(e){
      e.preventDefault();
      document.location.href = window.siwapp_urls.editRow;
    });
  }
  
  if (window.siwapp_urls.setAsDefault)
  {
    tb.find('[rel=templates:default]').click(function(e){
      e.preventDefault();
      var frm = $(this).closest('form');
      switch (frm.find('input:checkbox[rel=item]:checked').length)
      {
        case 0:
          alert(__('No selection. Nothing to do.'));
          break;
        case 1:
          frm.attr('action', window.siwapp_urls.setAsDefault).submit();
          break;
        default:
          alert(__('You must select only one template to set as default!'));
          break;
      }
    });
  }
  
  if (window.siwapp_urls.deleteAction)
  {
    tb.find('[rel=templates:delete]').click(function(e){
      e.preventDefault();
      var frm = $(this).closest('form');
      if (frm.find('input:checkbox[rel=item]:checked').length)
        frm.attr('action', window.siwapp_urls.deleteAction).submit();
    });
  }
  
});