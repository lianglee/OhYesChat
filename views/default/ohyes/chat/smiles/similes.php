<style>
.ohyeschat-item-smiles{
	padding: 3px;
}
</style>
<?php

foreach(OhYesChat::loadIcons() as $val => $Icon){
  echo '<div class="OhYesChat-Inline-Table ohyeschat-item-smiles" title="'.$val.'" onClick=\'OhYesChat.InsertSmiles("'.$val.'",'.$vars['tab'].');\'>'.$Icon.'</div>';	
}