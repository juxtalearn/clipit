<table>
  <tr>
    <td><?php echo elgg_echo('bbar:user:enableicons'); ?></td>
    <td>&nbsp;</td>
    <td>
      <select name="params[friends_icons]">
        <option value="true" <?php if (!$vars['entity']->friends_icons || $vars['entity']->friends_icons == "true") echo "selected=\"yes\" "; ?>><?php echo elgg_echo('option:yes'); ?></option>
        <option value="false" <?php if ($vars['entity']->friends_icons == "false") echo "selected=\"yes\" "; ?>><?php echo elgg_echo('option:no'); ?></option>
      </select>
    </td>
  </tr>
</table>

