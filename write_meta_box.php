<label for="sendDaumView">
<select name="category" style="width: 100%;" onchange="jQuery('#trackback_url').val(this.value);">
	<option value=''>다음뷰에 송고하지 않음</option>
<?php
	foreach($category as $row) :
?>
	<optgroup style="font-style: normal; background: #aeaeae;" label="<?php echo $row->name?>">
<?php
		foreach($row->list->category as $list) :
?>
<option style="padding-left: 20px; background: #fff;" value="<?php echo $list->trackback_url?>"><?php echo $list->name?></option>
<?php
		endforeach;
?>
	</optgroup>
<?php
	endforeach;
?>
</select>
