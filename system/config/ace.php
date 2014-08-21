<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Contao;

if ($GLOBALS['TL_CONFIG']['useCE']):

?>
<script>window.ace || document.write('<script src="<?= TL_ASSETS_URL ?>components/ace/js/ace.js" charset="utf-8">\x3C/script>')</script>
<script>
window.ace && window.addEvent('domready', function() {
  var ta = $('<?= $selector ?>');

  var div = new Element('div', {
    'id':'<?= $selector ?>_div',
    'class':ta.get('class')
  }).inject(ta, 'after');

  ta.setStyle('display', 'none');

  var editor = ace.edit('<?= $selector ?>_div');
  editor.setTheme("ace/theme/clouds");
  editor.renderer.setScrollMargin(3, 3, 0, 0);
  editor.renderer.scrollBy(0, -6);
  editor.getSession().setValue(ta.value);
  editor.getSession().setMode("ace/mode/<?= Backend::getAceType($type) ?>");
  editor.getSession().setUseSoftTabs(false);

  editor.commands.addCommand({
    name: 'Fullscreen',
    bindKey: 'F11',
    exec: function(editor) {
      editor.container.toggleClass('fullsize');
      editor.resize();
    }
  });

  // Disable command conflicts with AltGr (see #5792)
  editor.commands.bindKey('Ctrl-alt-a|Ctrl-alt-e|Ctrl-alt-h|Ctrl-alt-l|Ctrl-alt-s', null);

  var updateHeight = function() {
    var newHeight
      = editor.getSession().getScreenLength()
      * (editor.renderer.lineHeight || 14)
      + editor.renderer.scrollBar.getWidth();
    editor.container.setStyle('height', Math.max(newHeight, editor.renderer.lineHeight) + 'px');
    editor.resize();
  };

  editor.on('focus', function() {
    Backend.getScrollOffset();
    updateHeight();
  });

  editor.getSession().on('change', function() {
    ta.value = editor.getValue();
    updateHeight();
  });

  updateHeight();
});
</script>
<?php endif; ?>
