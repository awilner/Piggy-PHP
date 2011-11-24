<?php
if(isset($accounts))
{

  // Add our own currency formats.
  $this->element('currency');
?>
<table>
  <thead>
    <tr>
      <th id="account_overview" colspan="2" scope="rowgroup">
        <?php
          echo $this->Js->link(__("Overview"),'/accounts/index/',
			   array(
				 'complete'=>'updateAll(transport,\''.Router::url('/accounts/index/').'\'); Element.hide(\'loading_div\'); Element.show(\'main_display\'); new Effect.Highlight(\'main_display\')',
				 'before'=>'Element.hide(\'main_display\'); Element.show(\'loading_div\')'
                                )
                           );
        ?>
      </th>
    </tr>
  </thead>
  <?php foreach($accounts as $type=>$list): ?>
  <tbody class="account_group">
    <tr>
      <th class="account_group_type" id="account_group_<?php echo $type; ?>" colspan="2" scope="rowgroup">
        <?php
          echo $this->Js->link(__($totals[$type]['name']),'/accounts/index/'.$type,
                           array(
				 'complete'=>'updateAll(transport,\''.Router::url('/accounts/index/'.$type).'\'); Element.hide(\'loading_div\'); Element.show(\'main_display\'); new Effect.Highlight(\'main_display\')',
				 'before'=>'Element.hide(\'main_display\'); Element.show(\'loading_div\')'
                                )
                           );
        ?>
      </th>
    </tr>
    <?php foreach($list as $account): ?>
    <tr>
      <th class="account" id="account_<?php echo $account['id']; ?>" scope="row">
        <?php
          echo $this->Js->link($account['name'],'/accounts/index/'.$account['id'],
                           array(
				 'complete'=>'updateAll(transport,\''.Router::url('/accounts/index/'.$account['id']).'\'); Element.hide(\'loading_div\'); Element.show(\'main_display\'); new Effect.Highlight(\'main_display\')',
				 'before'=>'Element.hide(\'main_display\'); Element.show(\'loading_div\')'
                                )
                           );
        ?>
      </th>
      <td class="value<?php if($account['balance'] < 0) echo " negative"; ?>"><?php echo $this->Number->currency($account['balance'],$account['currency']); ?></td>
    </tr>
    <? endforeach; ?>
    <tr class="account_group_total">
      <th class="account" scope="row"><?php echo __("Total"); ?></td>
      <td class="value<?php if($totals[$type]['balance'] < 0) echo " negative"; ?>"><?php echo $this->Number->currency($totals[$type]['balance'],$userDefaultCurrency); ?></td>
    </tr>
  </tbody>
  <? endforeach; ?>
  <tfoot id="net_worth">
    <tr>
      <th class="account" scope="row"><?php echo __("Net Worth"); ?></th>
      <td class="value<?php if($netWorth < 0) echo " negative"; ?>"><?php echo $this->Number->currency($netWorth,$userDefaultCurrency); ?></td>
    </tr>
  </tfoot>
</table>
<div class="button" onclick="location.href='accounts/add';" style="cursor:pointer;"><?php echo __("Add an account"); ?></div>
<?php echo $this->Js->writeBuffer(); ?>
<?php
}
?>
